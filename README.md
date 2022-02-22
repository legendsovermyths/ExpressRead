# ExpressRead
Library Management System

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
