SET @project_id = (SELECT id FROM mantis_project_table WHERE name = 'Northstar Commerce');
SET @admin_id = (SELECT id FROM mantis_user_table WHERE username = 'administrator');
SET @checkout_id = (SELECT id FROM mantis_category_table WHERE project_id = @project_id AND name = 'Checkout');
SET @account_id = (SELECT id FROM mantis_category_table WHERE project_id = @project_id AND name = 'Account');

INSERT INTO mantis_bug_text_table (description, steps_to_reproduce, additional_information) VALUES ('Customers see an unhelpful message when a card authorization is declined.', '', '');
SET @text_id = LAST_INSERT_ID();
INSERT INTO mantis_bug_table (project_id, reporter_id, handler_id, duplicate_id, priority, severity, reproducibility, status, resolution, projection, eta, bug_text_id, os, os_build, platform, version, fixed_in_version, build, profile_id, view_state, summary, sponsorship_total, sticky, target_version, category_id, date_submitted, due_date, last_updated) VALUES (@project_id, @admin_id, 0, 0, 30, 50, 10, 10, 10, 10, 10, @text_id, '', '', '', '', '', '', 0, 10, 'Checkout error response is unclear', 0, 0, '', @checkout_id, 1736933400, 1, 1736933400);
SET @checkout_bug_id = LAST_INSERT_ID();

INSERT INTO mantis_bug_text_table (description, steps_to_reproduce, additional_information) VALUES ('Support requested clearer reset instructions before the next release.', '', '');
SET @text_id = LAST_INSERT_ID();
INSERT INTO mantis_bug_table (project_id, reporter_id, handler_id, duplicate_id, priority, severity, reproducibility, status, resolution, projection, eta, bug_text_id, os, os_build, platform, version, fixed_in_version, build, profile_id, view_state, summary, sponsorship_total, sticky, target_version, category_id, date_submitted, due_date, last_updated) VALUES (@project_id, @admin_id, 0, 0, 30, 50, 10, 20, 10, 10, 10, @text_id, '', '', '', '', '', '', 0, 10, 'Password reset email copy needs review', 0, 0, '', @account_id, 1738591200, 1, 1738591200);

INSERT INTO mantis_bug_text_table (description, steps_to_reproduce, additional_information) VALUES ('Moving to the second results page previously cleared the selected category filter.', '', '');
SET @text_id = LAST_INSERT_ID();
INSERT INTO mantis_bug_table (project_id, reporter_id, handler_id, duplicate_id, priority, severity, reproducibility, status, resolution, projection, eta, bug_text_id, os, os_build, platform, version, fixed_in_version, build, profile_id, view_state, summary, sponsorship_total, sticky, target_version, category_id, date_submitted, due_date, last_updated) VALUES (@project_id, @admin_id, 0, 0, 30, 50, 10, 80, 20, 10, 10, @text_id, '', '', '', '', '', '', 0, 10, 'Search results pagination loses selected filters', 0, 0, '', @checkout_id, 1734021900, 1, 1734021900);

INSERT INTO mantis_bugnote_text_table (note) VALUES ('Triage confirmed: capture the gateway response code in the support runbook.');
SET @note_text_id = LAST_INSERT_ID();
INSERT INTO mantis_bugnote_table (bug_id, reporter_id, bugnote_text_id, view_state, note_type, note_attr, time_tracking, last_modified, date_submitted) VALUES (@checkout_bug_id, @admin_id, @note_text_id, 10, 0, '', 0, 1737021600, 1737021600);
