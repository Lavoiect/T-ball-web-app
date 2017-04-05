# Populate POSITION Table
insert into position (name, default_position) values ('Pitcher', 1); 
insert into position (name, default_position) values ('Catcher', 1);
insert into position (name, default_position) values ('1st Base', 1);
insert into position (name, default_position) values ('2nd Base', 1);
insert into position (name, default_position) values ('Shortstop', 1);
insert into position (name, default_position) values ('3rd Base', 1);
insert into position (name, default_position) values ('Left Field', 1);
insert into position (name, default_position) values ('Right Field', 1);
insert into position (name, default_position) values ('Center Field', 1);

# Populate Default Team - needed for Admin Coach
insert into team (name) values ('');

# Populate COACH table
insert into coach (team_id, first_name, last_name, user_name, email, pwd, admin) values (1, 'Admin', 'Admin', 'Admin', 'admin@test.com', 'password', 1);
