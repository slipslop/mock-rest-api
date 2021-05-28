Version v1

Current resources:
person

Person fields:
required : [name, email]
id, type : string
name, type : string
email, type : string
phone, type : string
created, type : datetime
updated, type : datetime

Accepted methods:
GET, POST, PUT

examples:
GET persons
GET persons/:id
POST persons
PUT persons/:id

NOTE:
You might need to change the code at person.php on line 31 and 32, in order to get the correct id.