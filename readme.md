## About RestFul Meeting API[![Build Status](https://travis-ci.org/hamza094/Meeting-Restful-Api.svg?branch=master)](https://travis-ci.org/hamza094/Meeting-Restful-Api)

Simple Elegant Laravel API build for handle meeting schedule and it contained the following features:

- User SignUp/Login
- User Authentication with jwt-auth
- CRUD operation on meetings
- Register or Unregister user for a meeting 
- Test-Driven Development 

This API is accessible.

## Functionality
***You can use postman or other api tools to check this functionality***

- <b>User signup:-</b> For user signup go to (https://meetingsapi.herokuapp.com/api/v1/users) and give your name,email, and password to signup.(POST)
- <b>User signin:-</b> For user signup go to (https://meetingsapi.herokuapp.com/api/v1/user/signin) and give your name,and email and then get token.(POST)  
- <b>View Meetings:-</b> For view all meetings visit (https://meetingsapi.herokuapp.com/api/v1/meeting). (GET)
- <b>Show Meeting:-</b> For view specific meeting visit (https://meetingsapi.herokuapp.com/api/v1/meeting/1). (GET)
- <b>Create a new meeting:-</b> To create a  new meeting add title and description into the following (https://meetingsapi.herokuapp.com/api/v1/meeting?token=) and also give your token address.(POST)
- <b>Update meeting:-</b> For update meeting add title or description into the following (https://meetingsapi.herokuapp.com/api/v1/meeting/1?token=) and also give your token address only the person who created this meeting should perform this activity. (PATCH) 
- <b>Delete meeting:-</b> For delete meeting add a title or description into the following (https://meetingsapi.herokuapp.com/api/v1/meeting/1?token=) and also give your token address only the person who created this meeting should perform this activity. (DELETE)
- <b>Register User for meeting:-</b> For register user for specic meeting go to (https://meetingsapi.herokuapp.com/api/v1/meeting/registration?token=) add user_id and meeting_id also give your token adddress.(POST)
- <b>UnRegister User for meeting:-</b> For un-register user for specic meeting go to (https://meetingsapi.herokuapp.com/api/v1/meeting/registration?token=) add user_id and meeting_id also give your token adddress.(POST)

## Happy Coding
<i>@Created by hamza094</i>
<i>All right Reserved</i>

