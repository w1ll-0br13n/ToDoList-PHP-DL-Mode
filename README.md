# PHP Challenge

## TODO LIST PHP-MySQL [:link:][link]

### SETUP OF THE APPLICATION
### ** There are 3 branches (Main, Dockerization, Wordpress-todo-list-plugin) **

- Clone the repo after choosing the appropriated branch
- Download the database.sql file located at app/database.
- Import the sql file into your phpmyadmin.
- Open the config file (located at app/config.php): change your "Home" path to the path of application.
- Open the helper (located at app/helpers/helpers.php): Put you current database credentials and configurations.
*********************************************
---
- If you want to dockerize:
---
- Make sure docker is installed and configured on your computer or server.
- Modify the dockerfile if needed (path, working directory)
- Update the docker-compose.yml if needed (port)
- With these files in place, you can navigate to your plugin folder in the terminal and run docker-compose up to start a Docker container
*********************************************
---
- If you want wordpress plugin:
---
- Install WordPress on your local development environment or a web server.
- Set up a new WordPress plugin development environment by cloning the wordpress-todo-list-plugin branch into wp-content/plugins directory.
- You can now embed the app on any WordPress page or post using the shortcode 'GJK-006-WP-P' 
*********************************************
- Live demo: https://mozartdevs.com/todo-list

### Full screenshots

---

- At 1500px :computer:

![At 1500px][at1500px-l]

---

- At 1500px :computer:

![At 1500px][at1500px-l-d]

---

- At 1500px :computer:

![At 1500px][gif]

---

- At 375px :iphone:

| Light                                                                       | Dark                                                                       |
| -------------------------------------------------------------------------- | --------------------------------------------------------------------------- |
| <img src="./assets/images/phone-1.png" width="240" title="At 375px"> | <img src="./assets/images/phone-2.png" width="240" title="At 375px"> |

---

<!-- HTML content -->

<p align="center">WILL J. KEMMOE</p>
<p align="center"><a href="https://mozartdevs.com" title="Portfolio">Portfolio</a> • <a href="https://www.facebook.com/malucie24" title="AI Lucie">My AI</a></p>

[link]: https://mozartdevs.com/todo-list "Live Demo"
[at1500px-l]: ./assets/images/laptop-1.png "At 1500px"
[at1500px-l-d]: ./assets/images/laptop-2.png  "At 1500px"
[gif]: ./assets/gifs/todo.gif "At 1500px"
