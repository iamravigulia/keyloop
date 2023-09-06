Hi Keyloop

steps: 
1. clone this repo
2. create Database and set it into .env file
3. run ```composer install```
4. run ```npm install```
5. run ```php artisan serve```
6. run ```npm run dev``` or ```npm run build```
7. run ```php artisan migrate``` command
8. run ```php artisan fetch:properties```
9. check properties/index page


I have created ```php artisan fetch:properties``` command this will fetch all the properties and save into database

I have created a service which i called into command, in fetchProperties i have used recurrsion method to fetch properties

you can check index page on ```properties/index```

extras:

i have used tailwindcss for frontend, i have not did my best on frontend.

i have added ```intervention/image``` for image resize 