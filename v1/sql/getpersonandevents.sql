SELECT persons.id, events.* FROM persons
INNER JOIN events ON events.creator_id = persons.id