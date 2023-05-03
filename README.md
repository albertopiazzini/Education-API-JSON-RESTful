# Education-API-JSON-RESTful

Owly wants to experiment with new paths complementary to primary learning, developing cross-functional courses that can involve multiple subjects, thus stimulating the curiosity of the little ones.

I realize the API JSON RESTful to manage the entry and reading of these courses.


<h2> Specifications </h2>

Each subject is characterized by only one property: name

{
  "name" : "Javascript"
}


Each course is characterized by three properties: name, available places and subjects.

{
  "name" : "CourseExample",
  places_available:100,
  subjects:[13,14,15]
}


