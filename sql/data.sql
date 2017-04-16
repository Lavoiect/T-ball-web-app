# Populate POSITION Table
insert into position (name, list_order, default_position) values ('Left Field', 7, 1);
insert into position (name, list_order, default_position) values ('Pitcher', 1, 1); 
insert into position (name, list_order, default_position) values ('3rd Base', 6, 1);
insert into position (name, list_order, default_position) values ('Center Field', 8, 1);
insert into position (name, list_order, default_position) values ('Catcher', 2, 1);
insert into position (name, list_order, default_position) values ('Shortstop', 5, 1);
insert into position (name, list_order, default_position) values ('Right Field', 9, 1);
insert into position (name, list_order, default_position) values ('2nd Base', 4, 1);
insert into position (name, list_order, default_position) values ('1st Base', 3, 1);

# Populate Default Team - needed for Admin Coach
insert into team (name) values ('');

# Populate COACH table
insert into coach (team_id, first_name, last_name, user_name, email, pwd, admin) values (1, 'Admin', 'Admin', 'Admin', 'lavoiect@gmail.com', 'password', 1);
