/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function select2formatResult(data) {
    if (data.loading) {
        return data.text;
    };
    
    desc = data.text.toUpperCase();
    //find = query.term.toUpperCase();
    //lle = find.length;

    if (data.fl_active == 'N') {
        color = 'red';
    } else {
        color = 'black';
    }

    //ret = "<spam style ='color:" + color + ";'>" + desc + "</spam>";



    return data.text;
}


function select2formatSelection(object) {
    if (object.fl_active == 'N') {
        return "<spam style ='color:red;'>" + object.text + "</spam>";
    } else {
        return  object.text;
    }
}


function select2Start(selector, controller, defaultopt) {

    initData = undefined;

    if (defaultopt == undefined) {
        defaultopt = javaMessages.filterPlaceHolderAll;
    }

    if ($('#' + selector).attr('multi') == 'Y') {
        multi = true;
    } else {
        multi = false;
    }

    if ($('#' + selector).attr('plFixedSelect') != undefined) {
        autoPL = $.parseJSON($('#' + selector).attr('plFixedSelect'));
        initData = autoPL;
    } else {
        autoPL = [];
    }

    if ($('#' + selector).attr('default') != undefined) {
        initialSelect = $('#' + selector).attr('default');
        $('#' + selector).val(initialSelect);

    } else {
        initialSelect = undefined;
    }

    var select2Config = {};

    select2Config = {allowClear: true,
        placeholder: defaultopt,
        mySelector: selector,
        myRelatedCode: -1,
        myRelatedCodeOld: -1,
        dropdownAutoWidth: true,
        //multiple: multi,
        fixedPL: autoPL,
        data: autoPL,
        closeOnSelect: true
        //theme: 'bootstrap',
    };

    if (initData === undefined) {
        select2Config['ajax'] = {
            url: controller,
            cache: true,
            dataType: 'json',

            processResults: function (data) {
                ii = {};
                retu = [];
                $.each(data.items, function (index, item) {
                    ii = {text: item.description, id: item.recid, fl_active: item.fl_active};
                    //console.log(item);
                    retu.push(ii);
                });
                
                return {results: retu};
            }

        };



        select2Config['placeholder'] = {id: -1, text: defaultopt};
    }



    select2OnChangeFunction [selector] = undefined;

    $('#' + selector).select2(select2Config);


    $('#' + selector).on('change', function (e) {
        select2OnChanged(e, selector);

    });


    if ($('#' + selector).attr('startLocked') !== undefined) {
        select2Enable(selector, $('#' + selector).attr('startLocked') === 'N');
    }


}


function select2StartOld(selector, controller, defaultopt) {

    initData = undefined;

    if (defaultopt == undefined) {
        defaultopt = javaMessages.filterPlaceHolderAll;
    }

    if ($('#' + selector).attr('multi') == 'Y') {
        multi = true;
    } else {
        multi = false;
    }

    if ($('#' + selector).attr('plFixedSelect') != undefined) {
        autoPL = $.parseJSON($('#' + selector).attr('plFixedSelect'));
        initData = autoPL;
    } else {
        autoPL = [];
    }

    if ($('#' + selector).attr('default') != undefined) {
        initialSelect = $('#' + selector).attr('default');
        $('#' + selector).val(initialSelect);

    } else {
        initialSelect = undefined;
    }



    select2OnChangeFunction [selector] = undefined;

    if (initialSelect !== undefined) {

        $('#' + selector).select2({
            allowClear: true,
            placeholder: defaultopt,
            mySelector: selector,
            myRelatedCode: -1,
            myRelatedCodeOld: -1,
            dropdownAutoWidth: true,
            //multiple: multi,
            fixedPL: autoPL,
            data: autoPL,
            theme: 'bootstrap',
            formatResult: select2formatResult,
            formatSelection: select2formatSelection,
            escapeMarkup: function (m) {
                return m;
            }
        });



    } else {
        $('#' + selector).select2({
            allowClear: true,
            placeholder: defaultopt,
            cacheDataSource: null,
            ret: null,
            retwithf: null,
            myControllerName: controller,
            mySelector: selector,
            myRelatedCode: -1,
            myRelatedCodeOld: -1,
            dropdownAutoWidth: true,
            //multiple: multi,
            data: autoPL,
            fixedPL: autoPL,
            formatResult: select2formatResult,
            formatSelection: select2formatSelection,
            escapeMarkup: function (m) {
                return m;
            },
            query: function (query) {
                select2RunQuery(query, this);
                return;
            }
        });

    }


    $('#' + selector).on('change', function (e) {
        select2OnChanged(e, selector);
        if ($('#' + selector).attr('multi') == 'Y') {
            var fheight = $('#s2id_' + selector + ' > ul.select2-choices').height();
            if (fheight == 27) {
                fheight = 26;
            }
            $('#' + selector + '_frame').height(fheight + 19);
        }
    });


    if ($('#' + selector).attr('startLocked') !== undefined) {
        select2Enable(selector, $('#' + selector).attr('startLocked') === 'N');
    }


}

// roda a query que popula!
function select2RunQuery(query, self) {
    var cachedData = self.cacheDataSource;
    self.retwithf = [];

    if (query.element == undefined) {
        return;
    }

    // verifico se esse objeto demanda informacao de um outro!
    var related = query.element.attr('relatedFilter');
    var hasDeac = query.element.attr('hasDeact');
    var deactFilter = query.element.attr('deactFilter');
    var forceRelatedId = query.element.attr('forceRelatedId');


    var forceReset = query.element.attr('ForceReset');
    if (forceReset == undefined) {
        forceReset = 'N';
    }

    if (self.fixedPL.length > 0) {
        cachedData = self.fixedPL;
        forceReset = 'N';
    }

    var addtocontroller = '';

    addtocontroller = "/" + deactFilter;

    if (related != undefined) {
        var vlrc = $('#' + related).val();
        if (vlrc == '') {
            self.cacheDataSource = undefined;
            self.myRelatedCode = -1;

            query.callback({results: []});
            return;
        } else {
            addtocontroller = addtocontroller + '/' + vlrc;
        }
    } else {
        vlrc = '-1';
    }

    // force related ID, faz com que o sempre ele manda o valor padrao
    if (forceRelatedId != undefined) {
        addtocontroller = addtocontroller + '/' + forceRelatedId;
    }

    if (cachedData && vlrc == self.myRelatedCode && forceReset == 'N') {
        $.each(cachedData, function (index, item) {

            desc = item.text.toUpperCase();
            find = query.term.toUpperCase();
            lle = find.length;

            if (lle == 0 || desc.substring(0, lle) == find) {
                self.retwithf.push(item);
            }

        });

        query.callback({results: self.retwithf});
        return;
    } else {
        query.element.attr('ForceReset', 'N');

        $.ajax({
            url: self.myControllerName + addtocontroller,
            data: {searchterm: query.term},
            dataType: 'json',
            type: 'POST',
            success: function (data) {
                self.ret = [];
                self.retwithf = [];
                self.myRelatedCode = vlrc;
                ii = {};

                if (data.logged == undefined) {
                    data.logged = 'Y';
                }

                if (data.logged === 'N') {
                    sessionTimeOut();
                    return;
                }
                ii = {};

                $.each(data.items, function (index, item) {
                    ii = {text: item.description, id: item.recid, fl_active: item.fl_active};
                    self.ret.push(ii);

                });

                self.cacheDataSource = self.ret;
                self.ret = [];
                query.callback({results: self.cacheDataSource});
            }


        });
    }
}

function select2OnChanged(e, selector) {
    // faco uma procura em todos os objetos que sao relacionados a ele.
    select2ResetRel(selector);

    // funcao recebida por parametro caso o usuario deseje!!!
    if (select2OnChangeFunction[selector] != undefined) {
        select2OnChangeFunction[selector](selector, e);
    }

}

function  select2ResetRel(selector) {
    
    $('.picklist_filter').each(function () {
        //console.log($(this).attr('name'));
        
        rel = $(this).attr('relatedFilter');
        valr = $(this).val();
        
        if (rel == selector && valr != '') {
            $(this).val('-1');
            recid = $(this).attr('id');
            select2ResetRel(recid);
        }

    });
}


function select2Tags(selector, controller) {

    $('#' + selector).select2({
        tags: true,
        tokenSeparators: [',', ' '],
        dropdownAutoWidth: false,
        initialLoad: [],
        formatSelection: select2formatSelection,
        createSearchChoice: function (term, data) {
            if ($(data).filter(function () {
                return this.text.toUpperCase().localeCompare(term.toUpperCase()) === 0;
            }).length === 0) {
                return {
                    id: '.' + term.toUpperCase(),
                    text: term.toUpperCase() + '(New Tag)'
                };
            }
        },
        ajax: {
            url: controller,
            dataType: 'json',
            data: function (term, page) {
                return {
                    q: term
                };
            },
            results: function (data, page) {
                return {
                    results: data
                };
            }
        },
        // Some nice improvements:

        // max tags is 3
        maximumSelectionSize: 20,
        // override message for max tags
        formatSelectionTooBig: function (limit) {
            return "Max tags is only " + limit;
        }
    });

    // funcao recebida por parametro caso o usuario deseje!!!
    $('#' + selector).on('change', function (e) {
        if (select2OnChangeFunction[selector] != undefined) {
            select2OnChangeFunction[selector](selector, e);
        }
    });


}

function select2Enable(selector, bool) {

    $('#' + selector).select2("enable", bool);
}

function select2Reset(selector) {
    $('#' + selector).select2("val", '');
}

function select2FullReset(selector) {
    $('#' + selector).select2("val", '');
    $('#' + selector).attr('ForceReset', 'Y');

}


function select2Val(selector, val) {
    $('#' + selector).select2("val", val);
}

function select2Data(selector, val) {
    $('#' + selector).select2("data", val);
}

function select2ReadOnly(selector, val) {
    $('#' + selector).select2("readonly", val);
}


function select2InitialData(selector, val) {
    tag2InitialData[selector] = val;
    $('#' + selector).select2("data", val);
}

function select2GetData(selector) {
    return $('#' + selector).select2("data");
}
function select2onChange(selector, funct) {
    select2OnChangeFunction[selector] = funct;
}

function Select2TagRetChangesasFlag(selector) {

    var tagnow = select2GetData(selector);
    var tagremoved = $(tag2InitialData[selector]).not(tagnow).get();
    var tagadded = $(tagnow).not(tag2InitialData[selector]).get();
    var tagchanged = [];

    $.each(tagremoved, function (index, elem) {
        var row = {recid: elem.id, fl_checked: 0, ds_tag: elem.text};
        tagchanged.push(row);
    });

    $.each(tagadded, function (index, elem) {
        var row = {recid: elem.id, fl_checked: 1, ds_tag: elem.text};
        tagchanged.push(row);
    });

    return tagchanged;
}

function Select2TagAddData(selector, id, text) {
    var tagnow = select2GetData(selector);
    tagnow.push({id: id, text: text});
    $('#' + selector).select2("data", tagnow);

}

function Select2TagDelData(selector, id) {
    var tagnow = select2GetData(selector);
    var newData = [];

    $.each(tagnow, function (index, elem) {
        if (elem.id != id) {
            var row = {id: elem.id, text: elem.text};
            newData.push(row);
        }
    });

    $('#' + selector).select2("data", newData);

}

function Select2TagUpdByChanges(selector, changes) {

    var tagnow = select2GetData(selector);
    var newData = [];
    var removes = [];

    $.each(changes, function (index, value) {
        if (value.fl_checked == 1) {
            tagnow.push({id: value.recid, text: value.ds_tag});
        } else {
            removes[value.recid] = 'Y';
        }
    });

    $.each(tagnow, function (index, value) {
        if (removes[value.id] === undefined) {
            newData.push(value);
        }
    });

    $('#' + selector).select2("data", newData);

}


function setSimpleFilterContextMenu(selector) {
    var selc = selector + "_context";

    $(function () {
        $('#' + selc).contextPopup({
            title: javaMessages.filterOperator,
            rightOrLeft: 'left',
            originalSelector: selector,
            items: [
                {label: javaMessages.filterClear, id: 'X', action: function (e, set) {
                        $('#' + set.originalSelector).val('');
                    }},
                null,
                {label: javaMessages.fitterStartWith, id: 'S', action: function (e, set) {
                        $('#' + set.originalSelector).attr('likeSearch', 'S');
                    }},
                {label: javaMessages.filterLike, id: 'L', checked: true, action: function (e, set) {
                        $('#' + set.originalSelector).attr('likeSearch', 'L');
                    }}

            ],
            preopenbyitem: function (selector, item, settings) {
                var sel2 = $('#' + settings.originalSelector).attr('likeSearch');

                item.checked = (item.id == sel2);

                return item;
            }
        });
    });



}

function setPLContextMenu(selector) {

    var selc = selector + "_context";

    var its = [];

    its.push({label: javaMessages.filterRefresh, id: "X", iconfont: 'fa fa-refresh', action: function (e, set) {
            select2FullReset(set.originalSelector);
            select2ResetRel(set.originalSelector);
        }});



    if ($('#' + selector).attr('hasDeact') == 'Y') {
        its.push(null);

        its.push({label: javaMessages.filterShowAll, id: "0", action: function (e, set) {
                $('#' + set.originalSelector).attr('deactFilter', '0');
                select2FullReset(set.originalSelector);
                select2ResetRel(set.originalSelector);

            }});

        its.push({label: javaMessages.filterShowActive, id: "1", action: function (e, set) {
                $('#' + set.originalSelector).attr('deactFilter', '1');
                select2FullReset(set.originalSelector);
                select2ResetRel(set.originalSelector);
            }});
        its.push({label: javaMessages.filterShowDeac, id: "2", action: function (e, set) {
                $('#' + set.originalSelector).attr('deactFilter', '2');
                select2FullReset(set.originalSelector);
                select2ResetRel(set.originalSelector);


            }});


    }


    if (its.length == 0) {
        $('#' + selc).remove();
        return;
    }

    $(function () {
        $('#' + selc).contextPopup({
            title: javaMessages.filterOperator,
            rightOrLeft: 'left',
            originalSelector: selector,
            items: its,
            preopen: function (selector, settings) {
                var disabled = $('#' + settings.originalSelector).prop('disabled');
                settings.disabled = disabled;
                return settings;
            },
            preopenbyitem: function (selector, item, settings) {
                var sel2 = $('#' + settings.originalSelector).attr('deactFilter');

                item.checked = (item.id == sel2);

                return item;
            }
        });
    });



}