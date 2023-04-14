Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();

            // Socialite
            $table->string('provider')->nullable();
            $table->string('provider_id')->nullable();
            $table->string('avatar')->nullable();

            // Laravel Sanctum
            $table->string('api_token', 80)->unique()->nullable()->default(null);

            // Laravel Permission
            $table->string('role')->nullable();

            // Profile Image
            $table->string('profile_image')->nullable();

            // Location data i.e. city, state, country, zip code, address
            $table->string('city')->nullable();
            $table->string('state')->nullable();
            $table->string('country')->nullable();
            $table->string('zip_code')->nullable();
            $table->string('address')->nullable();

            // Phone number
            $table->string('phone')->nullable();

            // Timezone data
            $table->string('timezone')->nullable();

            // About me
            $table->text('about_me')->nullable();

            $table->timestamps();
        });
