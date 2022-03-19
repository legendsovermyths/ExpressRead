# ExpressRead
Library Management System

## ER Diagram
![image (4)](https://user-images.githubusercontent.com/63259605/159131277-20a02109-d106-448a-a778-7cb3cfc81afe.png)


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



