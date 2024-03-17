# Laravel 11 Breeze CRUD Roles, Users

## Развертывание:
```cmd
git clone https://github.com/eonvse/timedata2.1.git
cd laravel11
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
sail up
sail shell
composer install
npm run build
php artisan migrate
#php artisan db:seed
php artisan db:seed --class=PermissionSeeder
php artisan db:seed --class=SuperAdminSeeder

```   	
* [Laravel 11](https://laravel.com/docs/11.x)
    * [Laravel Sail (Docker)](https://laravel.com/docs/11.x/sail#main-content)
    * [Laravel Breeze](https://laravel.com/docs/11.x/starter-kits#breeze-and-livewire)
    * [Spatie Permission](https://laravel-news.com/jetstream-spatie-permission)

## Сопровождение

* Re-authenticate with GitHub. 
```
gh auth login
```

## Авторские права:
* Фреймворки
	* [Laravel 11](https://laravel.com/docs/11.x)
	* [Tailwindcss 3](https://tailwindcss.com/docs/installation)
	* [Livewire 3](https://livewire.laravel.com/docs)
        * [Livewire Volt](https://livewire.laravel.com/docs/volt)
* SVG иконки
	* [Tailwind Toolbox](https://tailwindtoolbox.com/icons)
	* [SVG Repo - Search, explore, edit and share open-licensed SVG vectors](https://www.svgrepo.com/)
