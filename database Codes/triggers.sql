DROP TRIGGER IF EXISTS leave_applications_insert_trigger;
DELIMITER ->
CREATE TRIGGER leave_applications_insert_trigger AFTER INSERT ON leave_applications
	FOR EACH ROW
	BEGIN 
		INSERT INTO action_on_applications (leave_application_id) VALUES(new.id) ;
    END; ->