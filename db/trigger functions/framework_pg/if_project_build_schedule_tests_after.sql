-- Function: audit.if_tablelog()

-- DROP FUNCTION audit.if_tablelog();


CREATE OR REPLACE FUNCTION schedule.if_project_build_schedule_tests_after()
  RETURNS trigger AS
$BODY$
DECLARE
    v_error_text text;
    v_error_code int;


BEGIN
    -- start without error!
    v_error_code = 0;



   --updates
    IF (TG_OP = 'UPDATE') THEN

        IF NEW.dt_est_start IS DISTINCT FROM OLD.dt_est_start OR NEW.dt_est_finish IS DISTINCT FROM OLD.dt_est_finish THEN
            INSERT INTO schedule."PROJECT_BUILD_SCHEDULE_TESTS_DATES_HISTORY" (cd_project_build_schedule_tests, dt_start, dt_finish, cd_human_resource_record, ds_type_date)
            VALUES (NEW.cd_project_build_schedule_tests, NEW.dt_est_start, NEW.dt_est_finish, get_var('cd_human_resource')::integer , 'P' );
        END IF;

        IF NEW.dt_start IS DISTINCT FROM OLD.dt_start OR NEW.dt_finish IS DISTINCT FROM OLD.dt_finish THEN
            INSERT INTO schedule."PROJECT_BUILD_SCHEDULE_TESTS_DATES_HISTORY" (cd_project_build_schedule_tests, dt_start, dt_finish, cd_human_resource_record, ds_type_date)
            VALUES (NEW.cd_project_build_schedule_tests, NEW.dt_start, NEW.dt_finish, get_var('cd_human_resource')::integer , 'A' );
        END IF;
x



    --delete
    ELSIF (TG_OP = 'DELETE') THEN

    --insert
    ELSIF (TG_OP = 'INSERT') THEN

        INSERT INTO schedule."PROJECT_BUILD_SCHEDULE_TESTS_DATES_HISTORY" (cd_project_build_schedule_tests, dt_start, dt_finish, cd_human_resource_record, ds_type_date)
        VALUES (NEW.cd_project_build_schedule_tests, NEW.dt_est_start, NEW.dt_est_finish, get_var('cd_human_resource')::integer , 'P' );

        INSERT INTO schedule."PROJECT_BUILD_SCHEDULE_TESTS_DATES_HISTORY" (cd_project_build_schedule_tests, dt_start, dt_finish, cd_human_resource_record, ds_type_date)
        VALUES (NEW.cd_project_build_schedule_tests, NEW.dt_start, NEW.dt_finish, get_var('cd_human_resource')::integer , 'A' );


    ELSE
        RAISE EXCEPTION 'Trigger func added as trigger for unhandled case: %, %',TG_OP, TG_LEVEL;
        RETURN NULL;
    END IF;


   --updates ou insert
    IF (TG_OP = 'UPDATE' OR TG_OP = 'INSERT') THEN

    END IF;




    -- controle de erro!!!!
    IF v_error_code > 0 THEN

        SELECT getTriggerError (v_error_code, null)
          INTO v_error_text;

        RAISE EXCEPTION '% (%)', v_error_text, v_error_code;
    END IF;


  -- Retorna OK
  IF TG_OP = 'DELETE' THEN 
    RETURN OLD;
  ELSE
    RETURN NEW;
   END IF;

END;
$BODY$
  LANGUAGE plpgsql VOLATILE SECURITY DEFINER
  COST 100;

ALTER FUNCTION schedule.if_project_build_schedule_tests_after() SET search_path=pg_catalog, public, tti, schedule;

ALTER FUNCTION schedule.if_project_build_schedule_tests_after() OWNER TO postgres;

/*
CREATE TRIGGER t_project_build_schedule_tests_after
  AFTER UPDATE OR INSERT OR DELETE
  ON schedule."PROJECT_BUILD_SCHEDULE_TESTS"
  FOR EACH ROW
  EXECUTE PROCEDURE schedule.if_project_build_schedule_tests_after();
*/

