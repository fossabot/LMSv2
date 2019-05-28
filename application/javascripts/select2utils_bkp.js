/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


function select2formatResult(object, container, query) {
    desc = object.text.toUpperCase();
    find = query.term.toUpperCase();
    lle = find.length;

    if (object.fl_active == 'N') {
        color = 'red';
    } else {
        color = 'black';
        "+color+"
    }

    ret = '';
    if (desc.substring(0, lle) == find && lle != 0) {
        ret = "<spam style ='color:" + color + "; text-decoration: underline;'>" + desc.substring(0, lle) + "</spam>";
    }


    ret = ret + "<spam style ='color: " + color + ";'>" + desc.substring(lle) + "</spam>";

    return ret;
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

    if ($('#' + selector).attr('multiple') == 'multiple') {
        var multi = true;
    } else {
        var multi = false;
    }

    if ($('#' + selector).attr('plFixedSelect') != undefined) {
        var jsonFixed = $.parseJSON($('#' + selector).attr('plFixedSelect'));
        var autoPL = jsonFixed;
        var initData = autoPL;

        if (typeof jsonFixed[0]['sql'] == 'object') {
            var isWithWithout = true;
            $('#' + selector).attr('isWithout', 'Y').attr('isWithoutSelected', '10');

        } else {
            var isWithWithout = false;
        }

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
            multiple: multi,
            fixedPL: autoPL,
            data: autoPL,
            isWithOut: isWithWithout,
            theme: 'bootstrap',
            containerCssClass: ':all:',

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
            multiple: multi,
            data: autoPL,
            fixedPL: autoPL,
            isWithOut: isWithWithout,
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
            //var fheight = $('#s2id_' + selector + ' > ul.select2-choices').height();
            //if (fheight == 27) {
            //  fheight = 26;
            // }
            //$('#' + selector + '_frame').height(fheight + 19);
        }
    });




    if ($('#' + selector).attr('selectedData') !== undefined) {
        var dataj = $.parseJSON($('#' + selector).attr('selectedData'));

        //console.log(dataj);

        if (!isWithWithout) {
            if (!multi) {
                $('#' + selector).select2('data', dataj[0]);
            } else {
                $('#' + selector).select2('data', dataj);
            }
        } else {
            var voptions = JSON.parse($('#' + selector).attr('plfixedselect'));
            select2DefaultForWithWithout(selector, voptions, dataj);

        }
    }

    if ($('#' + selector).attr('startLocked') !== undefined) {
        select2Enable(selector, $('#' + selector).attr('startLocked') === 'N');
    }


    if (isWithWithout) {
        $('#' + selector).on("select2-opening", function (e, i) {
            var vname = $(this).attr('id');
            var voptions = JSON.parse($(this).attr('plfixedselect'));
            var vselected = select2GetData(vname);

            if (multi) {
                e.preventDefault();
                select2MakePopup(vname, voptions, vselected);


            }
        }).on('change', function () {
        });
    }
}

function select2DefaultForWithWithout(id, options, vdef) {

    var vsel = [];
    $.each(vdef, function (id, vd) {
        $.each(options, function (io, vo) {

            if (vo.iddesc == vd.id) {
                
                $.each(vo.sql, function (is, vs) {

                    if (vs.optDesc.toLowerCase() == vd.text.toLowerCase()) {
                        vsel.push({id: vs.id, text: '<strong>'+vs.optDesc + '</strong> ' + vo.text, selected: vs.id, idx: io})
                        return false;
                    }


                });

                return false;
            }





        })
    });

    select2Data(id, vsel);
}

function select2MakePopup(vid, voptions, vselected) {
    var vid_pop = vid + '_popover';
    var vtitle = $("label[for='" + vid + "']").text();

    $field = $('#' + vid);
    var vhtml = '<div id="' + vid_pop + '" class="popover " style="width: 400px;min-width:370px;z-index: 100000" ><div class="arrow"></div><h3 class="popover-title">' + vtitle + '</h3><div class="popover-content" >';

    vhtml = vhtml + '<div class="row" id="popover_my_content" style="overflow-y: auto; ">';

    $.each(voptions, function (i, v) {

        var vSel = '';
        var vIdSel = -1;

        $.each(vselected, function (is, vs) {
            if (vs.idx == i) {
                vIdSel = vs.selected;
            }
        });


        if (vIdSel == -1) {
            vSel = 'selected';
        }

        vhtml = vhtml +
                '<div class="col-md-12" style="margin-bottom: 5px;">' +
                '<div class="col-md-4 col-xs-6" style="height: 32px;padding-right: 3px;padding-left: 0px;"> ' +
                '<select style="width: 100%;" class="' + vid_pop + '_select" idOpt="' + i + '">' +
                '  <option value="-1" ' + vSel + '>' + javaMessages.filterAny + '</option>';

        $.each(v['sql'], function (id, vd) {
            //console.log(id, vd);

            vSel = '';
            if (vIdSel == vd.id) {
                vSel = 'selected';
            }

            vhtml = vhtml + '  <option value="' + vd.id + '"  ' + vSel + ' idOptSelect="' + id + '" >' + vd.optDesc + '</option>';


        });

        vhtml = vhtml + '</select>' +
                '</div>' +
                '<div class="col-md-8 col-xs-6" style="font-size: 12px;padding-top: 10px;padding-left: 2px;"> ' +
                v.text +
                '</div>' +
                '</div><hr>';



    });


    vhtml = vhtml + '</div>   <div class="row"><div class="col-md-4"><button class="btn btn-warning" style="width: 100%;" onclick="select2ClosePopUp(\'' + vid_pop + '\', \'' + vid + '\');">' + javaMessages.buttonCancel + '</button></div> <div class="col-md-offset-4 col-md-4"><button class="btn btn-primary" style="width: 100%;" id="popSelectStatus">' + javaMessages.buttonOK + '</button>  </div></div>';

    vhtml = vhtml + '</div></div>';



    $('.content').append(vhtml).find('.' + vid_pop + '_select').select2();
    $('#' + vid_pop).find('#popSelectStatus').on('click', function () {
        select2OKPopUp(vid_pop, vid, voptions);
    })

    //$('#srPenaltyDiv').modalPopover({'modal-position': 'relative', target: event.originalEvent.target, placement: 'top'});


    $('#' + vid_pop).popoverX({
        target: '#s2id_' + vid,
        placement: 'auto',
        'modal-position': 'relative',
        size: 'md',
        show: true
    });
    //$('#' + vid_pop).popoverX('show');

    select2PositionPopUp(vid_pop);

    $(window).on('resize.popmodal', function () {
        select2PositionPopUp(vid_pop);
    });

    setTimeout(function () {
        $('#popover_my_content').attr("tabindex", -1).focus().attr("tabindex", '');

    }, 100);


}

function select2PositionPopUp(id_modal) {
    //var vmaxheight = $(window).height() - 100;
    var $modal = $('#' + id_modal);
    var $vcont = $('#popover_my_content');

    $vcont.css('max-height', '');
    $('#' + id_modal).popoverX('refreshPosition');

    var vTop = $modal.hasClass('top');
    var vBottom = $modal.hasClass('bottom');
    var vLeft = $modal.hasClass('left');
    var vRight = $modal.hasClass('right');
    var vModalTopPX = $modal.offset().top;
    var vModalHeifht = $modal.height();
    var vmax = '';
    var toRemove;

    if (vLeft || vRight) {
        vmax = '90vh';
    }

    if (vBottom) {
        toRemove = vModalTopPX + 50;
        vmax = 'calc(90vh - ' + toRemove + 'px )';
    }


    if (vTop) {
        toRemove = vModalTopPX + vModalHeifht + 50;
        vmax = 'calc(90vh - ' + toRemove + 'px )';
    }


    $vcont.css('max-height', vmax);




}

function select2ClosePopUp(id_modal, id) {
    $('#' + id_modal).popoverX('hide');
    $('#' + id_modal).popoverX('destroy');

    $('#' + id_modal).remove();
    $(window).off('resize.popmodal');
}

function select2OKPopUp(id_modal, id, voptions) {
    select2Reset(id);
    var vdata = [];



    $('#' + id_modal).find('select').each(function () {

        var vid = $(this).attr('idopt');
        var vselec = $(this).val();
        var vIdIndexSql = $(this).find('option:selected').attr('idOptSelect');

        if (vselec == -1) {
            return true;
        }

        var vopt = voptions[vid];

        var vidsql = vopt['sql'][vIdIndexSql].id;
        var vtxt = '<strong>' + vopt['sql'][vIdIndexSql].optDesc + '</strong> ';



        var vdataitem = {id: vidsql, text: vtxt + vopt.text, selected: vselec, idx: vid};
        vdata.push(vdataitem);


    });

    select2Data(id, vdata);

    select2ClosePopUp(id_modal, id);



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


        $.myCgbAjax({url: self.myControllerName + addtocontroller,
            box: 'none',
            //message: javaMessages.inserting,
            data: {searchterm: query.term},
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
        rel = $(this).attr('relatedFilter');
        valr = $(this).select2("val");

        if (rel == selector && valr != '') {
            $(this).select2("val", "");
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

function select2Data(selector, val, append) {
    if (append) {
        var vtst = $('#' + selector).select2("data");
        val = vtst.concat(val);
    }
    
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

function setDateFilterContextMenu(selector) {
    var selc = selector + "_context";
    var frame = selector + "_frame";
    var vselector = selector;

    makeDemandedColor(selector);


    $('#' + vselector + "_to").on('change', function () {

        if ($('#' + vselector + '_frame').attr('dateSearch') !== 'B') {
            return;
        }

        var vlrfrom = $('#' + vselector + "_from").val();
        if (vlrfrom == '' || vlrfrom == undefined) {
            return;
        }

        var vlrto = $('#' + vselector + "_to").val();
        if (vlrto == '' || vlrto == undefined) {
            $('#' + vselector + "_to").val(vlrfrom);
            vlrto = vlrfrom;
            return;
        }

        var vdatefrom = w2utils.formatDate(vlrfrom, 'yyyymmdd');
        var vdateto = w2utils.formatDate(vlrto, 'yyyymmdd');

        if (parseInt(vdatefrom) > parseInt(vdateto)) {
            $('#' + vselector + "_to").val(vlrfrom);
            vlrto = vlrfrom;

        }

    });


    $('#' + vselector + "_from").on('change', function () {

        if ($('#' + vselector + '_frame').attr('dateSearch') !== 'B') {
            return;
        }


        var vlrfrom = $('#' + vselector + "_from").val();
        if (vlrfrom == '' || vlrfrom == undefined) {
            $('#' + vselector + "_to").val('');
            return;
        }

        var vlrto = $('#' + vselector + "_to").val();
        if (vlrto == '' || vlrto == undefined) {
            $('#' + vselector + "_to").val(vlrfrom);
            vlrto = vlrfrom;
            return;
        }

        var vdatefrom = w2utils.formatDate(vlrfrom, 'yyyymmdd');
        var vdateto = w2utils.formatDate(vlrto, 'yyyymmdd');

        if (parseInt(vdatefrom) > parseInt(vdateto)) {
            $('#' + vselector + "_to").val(vlrfrom);
            vlrto = vlrfrom;

        }

    });

    $('#' + frame).find('input').w2field('date');

    $(function () {
        $('#' + selc).contextPopup({
            title: javaMessages.filterOperator,
            rightOrLeft: 'left',
            originalSelector: selector,
            items: [
                {label: javaMessages.filterClear, id: 'X', iconfont: 'fa fa-eraser', action: function (e, set) {
                        $('#' + set.originalSelector + "_to").val('');
                        $('#' + set.originalSelector + "_from").val('');

                        setTimeout(function () {
                            $('#' + set.originalSelector + "_from").focus();
                        }, 100);

                    }},
                null,
                {label: javaMessages.filterBetween, id: 'B', checked: true, action: function (e, set) {
                        $('#' + set.originalSelector + '_frame').attr('dateSearch', 'B');
                        $('#' + set.originalSelector + "_to").prop('disabled', false);
                        $('#' + set.originalSelector + "_to").val($('#' + set.originalSelector + "_from").val());

                        setTimeout(function () {
                            $('#' + set.originalSelector).focus();
                        }, 100);

                    }},
                {label: javaMessages.filterEqual, id: 'E', action: function (e, set) {
                        $('#' + set.originalSelector + '_frame').attr('dateSearch', 'E');

                        $('#' + set.originalSelector + "_to").prop('disabled', true);
                        $('#' + set.originalSelector + "_to").val('');



                        setTimeout(function () {
                            $('#' + set.originalSelector).focus();
                        }, 100);


                    }}

            ],
            preopenbyitem: function (selector, item, settings) {
                var sel2 = $('#' + settings.originalSelector + '_frame').attr('dateSearch');


                item.checked = (item.id == sel2);

                return item;
            }
        });
    });
}

function makeDemandedColor(selector) {
    var frame = selector + "_frame";
    var vDem = $('#' + selector).attr('dem');
    if (vDem == 'Y') {
        $('#' + frame).find('.control-label-filter').css('color', 'blue');
    }

    if (vDem == 'A') {
        $('#' + frame).find('.control-label-filter').css('color', 'green');
    }

}

function setSimpleFilterContextMenu(selector) {
    var selc = selector + "_context";

    makeDemandedColor(selector);


    $(function () {
        $('#' + selc).contextPopup({
            title: javaMessages.filterOperator,
            rightOrLeft: 'left',
            originalSelector: selector,
            items: [
                {label: javaMessages.filterClear, id: 'X', iconfont: 'fa fa-eraser', action: function (e, set) {
                        $('#' + set.originalSelector).val('');

                        setTimeout(function () {
                            $('#' + set.originalSelector).focus();
                        }, 100);

                    }},
                null,
                {label: javaMessages.fitterStartWith, id: 'S', action: function (e, set) {
                        $('#' + set.originalSelector).attr('likeSearch', 'S');
                        setTimeout(function () {
                            $('#' + set.originalSelector).focus();
                        }, 100);

                    }},
                {label: javaMessages.filterLike, id: 'L', checked: true, action: function (e, set) {
                        $('#' + set.originalSelector).attr('likeSearch', 'L');

                        setTimeout(function () {
                            $('#' + set.originalSelector).focus();
                        }, 100);


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
    var selc_frame = selector + "_frame";
    var its = [];

    makeDemandedColor(selector);

    if ($('#' + selector).attr('plFixedSelect') == undefined) {

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


    } else {

        its.push({label: javaMessages.filterClear, id: "X", iconfont: 'fa fa-eraser', action: function (e, set) {
                select2FullReset(set.originalSelector);
                select2ResetRel(set.originalSelector);
            }});

        if ($('#' + selector).attr('isWithout') == 'Y' && $('#' + selector).attr('multiple') != 'multiple') {
            its.push(null);

            its.push({label: 'With', id: "10", action: function (e, set) {
                    $('#' + set.originalSelector).attr('isWithoutSelected', '10');
                }});
            its.push({label: 'Without', id: "11", action: function (e, set) {
                    $('#' + set.originalSelector).attr('isWithoutSelected', '11');
                }});
        }






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
                var sel3 = $('#' + settings.originalSelector).attr('isWithoutSelected');

                item.checked = (item.id == sel2 || sel3 == item.id);

                return item;
            }
        });
    });



}