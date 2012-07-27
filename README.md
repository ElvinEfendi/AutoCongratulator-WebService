AutoContratulator-WebService
============================

This is server side of AutoCongratulator program. It Allows users to send free sms through Azercell and Bakcell sercice.
User should have client program written in C# installed on their machine. With client they can send free sms from their 
Azercell or Bakcell account. User can also get registered in the system. Registration allows users to not forget birthday
of their friends and relatives. After user sign up in the system, he/she can create new birthday. 1 day prior do birthday
system will alert user by sending information sms. And when birthday comes it will send created sms to the appropriate number.

Configuration
-------------
To make this server side application work, all you need is to edit config file, create database and create a job
which will call va_core.php file periodically. You can of course call this prorgam via clien as well.