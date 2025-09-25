# USSD Deployment Guide for Africa's Talking

## Option 1: Free Hosting Services

### 1. Heroku (Recommended)
1. Create a free Heroku account
2. Install Heroku CLI
3. Create a `composer.json` file in your ussd folder:

```json
{
    "require": {
        "php": "^7.4|^8.0"
    }
}
```

4. Create a `Procfile`:
```
web: php -S 0.0.0.0:$PORT index.php
```

5. Deploy:
```bash
cd ussd
git init
git add .
git commit -m "Initial USSD app"
heroku create your-ussd-app-name
git push heroku main
```

### 2. Railway
1. Connect your GitHub repository
2. Deploy directly from your code

### 3. Vercel (with PHP runtime)
1. Install Vercel CLI
2. Deploy with `vercel --prod`

## Option 2: VPS/Cloud Server

### DigitalOcean Droplet
1. Create a $5/month droplet
2. Install Apache/Nginx + PHP
3. Upload your files
4. Configure virtual host

### AWS EC2
1. Launch t2.micro instance (free tier)
2. Install LAMP stack
3. Deploy your application

## Step 3: Configure Africa's Talking

1. **Login to Africa's Talking Dashboard**
2. **Go to USSD section**
3. **Create a new USSD application:**
   - Service Code: `*384*123#` (or your preferred code)
   - Callback URL: `https://your-app.herokuapp.com/index.php`
   - HTTP Method: POST

## Step 4: Test Your USSD

1. **Dial your USSD code** on your phone
2. **Follow the menu prompts**
3. **Test with the credentials:**
   - Phone: `0700000001`
   - Password: `password123`

## Important Notes

- Make sure your Laravel API is also publicly accessible
- Update the API_BASE_URL in config.php to your production API URL
- Test thoroughly before going live
- Monitor logs for any issues

## Troubleshooting

- Check Africa's Talking logs in their dashboard
- Verify your callback URL is accessible
- Ensure your server responds within 30 seconds
- Test with different phone numbers
