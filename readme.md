## TNTP App

#Instruction
- duplicate .env.example and rename to .env
- Fill the env details
- Configure your mail credential

Now run the following commands
- composer install
- npm install
- php artisan key generate
- npm run dev
- php artisan websockets:serve --port=6003


Now Run this to create admin account follow the wizard
- php artisan migrate:fresh --seed
