DROP TRIGGER IF EXISTS leave_applications_insert_trigger;
DELIMITER ->
CREATE TRIGGER leave_applications_insert_trigger AFTER INSERT ON leave_applications
	FOR EACH ROW
	BEGIN 
		INSERT INTO action_on_applications (leave_application_id) VALUES(new.id) ;
    END; ->


DROP TRIGGER IF EXISTS action_on_applications_insert_trigger;
DELIMITER ->
CREATE TRIGGER action_on_applications_insert_trigger AFTER INSERT ON action_on_applications
	FOR EACH ROW
	BEGIN
		INSERT INTO recommendation (action_on_applications_id) VALUES(new.id) ;
		INSERT INTO certification_of_leave_credits (action_on_applications_id) VALUES(new.id) ;
		INSERT INTO osds_action (action_on_applications_id) VALUES(new.id) ;
    END; ->