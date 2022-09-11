Katie Yang 2002344

______________________________________________________
|                                                    |
|   Don't think this is how acronyms work but        |
|   On this website you can coordinate your chores   |
|____________________________________________________|


< Overview >

This website is designed for multiple users living in separate households, where they add chores to be allocated to housemates.


< Core Functionalities >

User Registration: 
The user can sign up with a username that has not been taken. There's no check for emails as this website currently does not have an email notification function, but this could be implemented in the future. The user must choose a password that is longer than 8 digits. Once a user has been registered, they are taken to the login page.

User Authentication: 
The user's password is first encrypted with hash, then stored. When a user logs in, the website compares the hashed user input with the hashed password. If the password is correct, the user is logged in and taken to either the chores page or, if they have not joined a household, the join household page.

Adding a Chore: 
The user can add a chore in the household's chores page, via the button at the bottom. They have the option to include a name, a description, the size of the task (how difficult, or time-consuming it is), the frequency (ranging from once to monthly), the interval (if they chose a custom frequency), and lastly the date to start the chore. 

Chore Allocation Strategy: 
The website uses a weighting strategy to allocate the chores to users. A chore's starting value is 100 if it is a small chore, 400 for a medium chore and 1000 if it is a big chore. Then, this number is divided by the interval of the chore i.e. the more days between two repeats of a chore, the less its weight will be. Then, the user with the least (current) total chore weight is found, and the chore is given to them. If the chore is repeating, the same user will do the chore each time.

Chore Details:
Every member of the house can see the current chores in the house, and can mark it as complete, if they wish to do the chore for the person it's allocated to. Once a repeating chore is marked as complete, its due date is updated to its next due date. Once a one-time chore is marked as complete, it is permaently removed. Note that if a repeating chore is overdue, the website will keep the overdue chore, but make a copy of it due its first repeat after the current date, this means if a chore is not done, it will need to be done as well as the next repeat of it. This is helpful for things like paying for something, or making a meal. In the chore view, its title, description, user created by and allocated to, frequency, status, and the next due date is displayed. A chore can also be deleted via the delete button in detail view. 


< Additional Functionalities >

Households: 
The user is taken to the join household page if they are not already in a household. They can also create a new household, which require a unique name, and a password. Once a household is registered, any user can join it by entering the correct name and password on the 'Join Household' page. When a user adds a chore, every user in the same household can see the chore and its details. The household page is split into three tabs: active chores (due today or overdue), upcoming chores (due tomorrow and onwards), and members. Clicking onto members displays a list of current household members.

Personal Chores: 
The user can see their own active and upcoming chores by clicking onto the 'Chores' tab. This is essentially a filter for the household page.

Icons:
The user can choose from 9 different hand drawn icons (or rather mouse-drawn). This improves the look of the interface greatly: Each member of the household can now be associated with their icon. This is easier and more pleasant to look at than names of users. On chore/household view, each chore is displayed with the icon of the user they are allocated to, which provides the overview of chore distribution at a glance. 

Side Summary Bar:
The side bar displays the user's nickname and icon, as well as the name of their household, their next chore, and its deadline. This is meant to be a summary of the key information regarding the user, as well as an aesthetic choice. Clicking on the name or the icon takes the user to their account page.

Account Page:
The user can check their account details on the account page. This displays their username, nickname, email, date joined and their current household. On this page they have the option to change their nickname, which is used for all name display in the household instead of the username. This means two users can have the same nicknames. On this page the user can also select a different icon.


< Other Important Features >

Aesthetics:
This website is designed with a consistent, but slightly different style in mind. It may not look like the average website, which is usually designed to be minimalistic and sleek, with white and cool colours as its main palette. Although a minimalistic design is a popular choice as it is clear and easy to use, I wanted to style the website in a more interesting way, at the risk of it looking unprofessional. I have tried to design this website in a limited palette, as well as a retro style with the in/outset borders. Each button, as well as the chores, are designed to have a pressed look when hovered over. In the end, I think the website has turned out simplistic and straightforward to use.

Security:
The website should be able to handle XSS attacks and SQL injections. Everything the user types in is passed through an HTML character checker, which replaces any special characters with their code equivalent. To prevent SQL injections, each value is binded to a certain type before it is inserted into the database. This provides basic security checks for the website.

Accessibility:
To allow users with visual impairments to use this website, all fields in forms are labelled, and any images, namely the icons, used are labelled as well. 

User Experience:
JavaScript and AJAX is used to provide a smoother user experience. These are usually used on small changes to update elements in the page without the need to refresh the page itself. An example of this is the registration page, where AJAX is used to display any errors, such as a password that is too short; another place where this is utilised is the removal of chores on the household page, as well as the icon/nickname updates. 

__________________________________________________________________
|                                                                |
|   I hope this was helpful in explaining what my website does.  |
|________________________________________________________________|