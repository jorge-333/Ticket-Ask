# Ticket-Ask
ASU - Senior Capstone Project


### Table of Contents
- [Project Charter](#Project-Charter)
- [Functions & Requirements](#Business-Requirements)
   * [1. Client and Employee Web Portal](#Client-and-Employee-Web-Portal)
   * [2. Ticket Management](#Ticket-Management)
   * [3. Notification/Alert System](#Notification/Alert-System)
   * [4. File Upload](#File-Upload)
- [System Design](#System-Design)
   * [Network Topology Diagram](#Network-Topology-Diagram)
   * [Entity-Relationship Diagram](#Entity-Relationship-Diagram)


### Project Charter
TicketAsk is a helpdesk system that offers a Customer and Employee Portal that meets the necessary requirements needed to have the main functions to manage tickets be notified of ticket progress and communicate back and forth with the support team until ticked is resolved.

### Business Requirements

#### 1. Client and Employee Web Portal
<img src="Screenshots/wireframe.png" width="100%">

#### 2. Ticket Management
* Requirements:
  - The system allows the user and agent to: 
    - open a new ticket
    - edit an existing ticket
    - close a fulfilled or resolved ticket
    - view the status of open tickets
  - The system will allow agents:
    - to request additional information on tickets.
  - The system will retain all past tickets.
  - The system will allow the user to filter and search through past and current tickets.

#### 3. Notification/Alert System
* Requirements:
  - The system alerts the customer when their ticket has been completed and closed.
  - The system alerts the customer when a request for more information has been made.
  - The system alerts the customer when a new technician or agent has been assigned to their ticket.

#### 4. File Upload
* Requirements:
  - The system allows the customer to upload .docx .pdf .jpeg and .png .zip files.
  - The system allows the customer to delete uploaded files.
  - The system displays an error message for unsupported file types and for files that are too large.
 
### System Design

#### Network Topology Diagram
<img src="Screenshots/network.png" width="50%">

#### Entity-Relationship Diagram
<img src="Screenshots/uml.png" width="50%">

