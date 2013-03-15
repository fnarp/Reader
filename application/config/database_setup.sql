CREATE TABLE feed_items (
	id int(11) NOT NULL AUTO_INCREMENT,
	parent int(11) NOT NULL,
	uid text NOT NULL,
	title text NOT NULL,
	link text NOT NULL,
	content text,
	pubDate text,
	image text,
	PRIMARY KEY (id),
	KEY uid (uid)
);

CREATE TABLE feed_items (
	id int(11) NOT NULL AUTO_INCREMENT,
	parent int(11) NOT NULL,
	uid text NOT NULL,
	title text NOT NULL,
	link text NOT NULL,
	description text,
	language text,
	copyright text,
	managingEditor text,
	webMaster text,
	pubDate text,
	lastBuildDate text,
	category text,
	generator text,
	docs text,
	cloud text,
	ttl text,
	image text,
	textInput text,
	skipHours text,
	skipDays text,
	PRIMARY KEY (id)
);

CREATE TABLE feeds (
	id int(11) NOT NULL AUTO_INCREMENT,
	title text NOT NULL,
	uri varchar(767) NOT NULL UNIQUE,
	icon text,
	description text,
	last_update int,
	update_frequency int,
	PRIMARY KEY (id),
	KEY last_update (last_update)
);

CREATE TABLE userfeeds (
	id int(11) NOT NULL AUTO_INCREMENT,
	userid int(11) NOT NULL,
	feedid int(11) NOT NULL,
	groupid int(11),
	uipos int(11),
	PRIMARY KEY (id),
	KEY userid (userid)
);

CREATE TABLE usergroups (
	id int(11) NOT NULL AUTO_INCREMENT,
	userid int(11) NOT NULL,
	title text NOT NULL,
	uipos int(11),
	public boolean,
	KEY id (id)
);
