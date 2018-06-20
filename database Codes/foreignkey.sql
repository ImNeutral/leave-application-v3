ALTER TABLE certification_of_leave_credits DROP FOREIGN KEY certification_of_leave_credits_action_on_applications_id;
ALTER TABLE certification_of_leave_credits DROP INDEX certification_of_leave_credits_action_on_applications_id;
ALTER TABLE certification_of_leave_credits ADD CONSTRAINT certification_of_leave_credits_action_on_applications_id
	FOREIGN KEY (action_on_applications_id) REFERENCES action_on_applications(id)
    	ON DELETE CASCADE;


ALTER TABLE recommendation DROP FOREIGN KEY recommendation_action_on_applications_id;
ALTER TABLE recommendation DROP INDEX recommendation_action_on_applications_id;
ALTER TABLE recommendation ADD CONSTRAINT recommendation_action_on_applications_id
	FOREIGN KEY (action_on_applications_id) REFERENCES action_on_applications(id)
    	ON DELETE CASCADE;


ALTER TABLE osds_action DROP FOREIGN KEY osds_action_action_on_applications_id;
ALTER TABLE osds_action DROP INDEX osds_action_action_on_applications_id;
ALTER TABLE osds_action ADD CONSTRAINT osds_action_action_on_applications_id
	FOREIGN KEY (action_on_applications_id) REFERENCES action_on_applications(id)
    	ON DELETE CASCADE;


