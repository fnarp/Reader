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
	feedid int(11) NOT NULL,
	uid text NOT NULL,
	title text NOT NULL,
	link text NOT NULL,
	description text,
	language text,
	copyright text,
	managingEditor text,
	webMaster text,
	pubDate int(11),
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
	PRIMARY KEY (id),
	KEY pubDate (pubDate),
	KEY feedid (feedid),
);

CREATE TABLE userfeed_items (
	id int(11) NOT NULL AUTO_INCREMENT,
	feeditemid int(11) NOT NULL,
	read boolean,
	favourite boolean,
	readlater boolean
)

CREATE TABLE feeds (
	id int(11) NOT NULL AUTO_INCREMENT,
	title text NOT NULL,
	uri varchar(767) NOT NULL UNIQUE,
	favicon text,
	touchicon text,
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
	public boolean
	PRIMARY KEY id (id),
	KEY userid (userid)
);

CREATE TABLE userfeed_items (
	id int(11) NOT NULL AUTO_INCREMENT,
	userid int(11) NOT NULL,
	feeditemid int(11) NOT NULL,
	seen boolean,
	favourite boolean,
	readlater boolean,
	PRIMARY KEY id (id),
	KEY userid (userid),
	KEY feeditemid (feeditemid)
)
