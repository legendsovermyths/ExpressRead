# ExpressRead
Library Management System

## ER Diagram
![ER Diagram](https://user-images.githubusercontent.com/62871606/158558338-6a95ffe1-747f-4321-8e86-2221566b87dd.png)

## Entities

### Member Table: 
	ID*
	Phone*
	Email*
	Designation (Student/Faculty)
	Fine/Due
	CollegeID
	Password
	VerificationStatus
			  
### Publisher Table:
	PublisherID*
	PublisherName
	PublisherEmail
	PublisherPhone

### Books Table:
	BookID*
	BookName
	BookRating
	BookGenre
	PublishersID*
	SectionID*

### Copy Table:
	BookID*
	CopyNum*
	CopyPrice
	CopyCondition

### Sections Table:
	SectionID*
	SectionFloor
	SectionRack
	
### Records Table:

### Wishlists Table:

### Authors Table:

### Waitlist Table:



