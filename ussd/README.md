# USSD Immunization Management System

This USSD application integrates with the Laravel immunization management system to provide mobile access to vaccination records and services.

## Features

- **Authentication**: Phone number or National ID based login
- **Immunization Status**: Check vaccination status for all children
- **Children Listing**: View all registered children with patient IDs
- **Vaccination History**: Complete vaccination history by child
- **Appointment Scheduling**: Information about scheduling appointments
- **Health Facilities**: List of available health facilities

## Setup Instructions

### 1. Prerequisites

- PHP 7.4 or higher
- cURL extension enabled
- Access to your Laravel API
- USSD gateway configured

### 2. Configuration

1. Update the API URL in `config.php`:
   ```php
   define('API_BASE_URL', 'http://your-laravel-api.com/api');
   ```

2. Ensure your Laravel API is running and accessible

3. Test the API endpoints manually to ensure they're working

### 3. USSD Gateway Configuration

Configure your USSD gateway to point to the appropriate file:
- Basic version: `ussd/index.php`
- Advanced version: `ussd/advanced_index.php`

### 4. File Structure

```
ussd/
├── index.php              # Basic USSD implementation
├── advanced_index.php     # Enhanced version with better error handling
├── config.php            # Configuration file
└── README.md             # This file
```

## Usage Examples

### Main Menu
```
*123# -> Main USSD code
1. Check immunization status
2. List my children
3. View vaccination history
4. Schedule appointment
5. Health facilities
0. Exit
```

### Authentication Flow
```
1 -> Enter your email address:
*123*1*guardian1@example.com# -> Enter your password:
*123*1*guardian1@example.com*password123# -> Check status for email guardian1@example.com
```

### Sample Responses

**Immunization Status:**
```
END Immunization Status:

Child: John Doe
Patient ID: 123456
Status: Up to date
Next Appointment: 2024-03-15

Child: Jane Doe
Patient ID: 789012
Status: Overdue
Next Appointment: 2024-02-20

0. Back to main menu
```

**Children Listing:**
```
END Your Children:

1. John Doe
   Patient ID: 123456
   DOB: 2020-01-15
   Gender: Male
   Status: Up to date

2. Jane Doe
   Patient ID: 789012
   DOB: 2021-05-20
   Gender: Female
   Status: Overdue

0. Back to main menu
```

## API Integration

The USSD system communicates with these Laravel API endpoints:

- `POST /api/login` - User authentication
- `GET /api/user` - Get authenticated user details
- `GET /api/guardians/{id}/babies` - Get children by guardian
- `GET /api/appointments/guardian/vaccination-history/{id}` - Get vaccination history
- `GET /api/vaccines` - Get available vaccines

## Error Handling

The system includes comprehensive error handling for:
- Authentication failures
- API connectivity issues
- Invalid user input
- Missing data

## Security Considerations

1. **Input Validation**: All user inputs are validated and sanitized
2. **Phone Number Formatting**: Automatic formatting of phone numbers
3. **API Token Management**: Secure token handling for API calls
4. **Error Logging**: Detailed logging for debugging and monitoring

## Customization

### Adding New Menu Options

1. Add new option to `$MENU_OPTIONS` in `config.php`
2. Add corresponding handler in the main switch statement
3. Implement the business logic function

### Modifying Health Facilities

Update the `$HEALTH_FACILITIES` array in `config.php` with your facility information.

### API Endpoint Changes

If your Laravel API endpoints change, update the corresponding function calls in the USSD files.

## Testing

### Test Data

Use these credentials to test your USSD system:

#### **Primary Test User:**
- **Email:** `guardian1@example.com`
- **Password:** `password123`
- **Name:** David Okafor
- **Role:** Guardian

#### **Additional Test Users:**
- **Email:** `guardian2@example.com` | **Password:** `password123` | **Name:** Amina Yusuf
- **Email:** `guardian3@example.com` | **Password:** `password123` | **Name:** Samuel Eze
- **Email:** `guardian4@example.com` | **Password:** `password123` | **Name:** Grace Abubakar
- **Email:** `guardian5@example.com` | **Password:** `password123` | **Name:** Peter Nwankwo

#### **Test Children Data:**
Each guardian has children with automatically generated patient IDs and immunization statuses.

### Local Testing with Ngrok

#### **Step 1: Install Ngrok**
1. Download ngrok from https://ngrok.com/
2. Extract and add to your PATH
3. Sign up for a free account
4. Get your authtoken from the dashboard
5. Run: `ngrok authtoken YOUR_TOKEN`

#### **Step 2: Start Your Laravel API**
```bash
cd backend
php artisan serve --host=0.0.0.0 --port=8000
```

#### **Step 3: Start Your USSD Server**
```bash
cd ussd
php -S 0.0.0.0:8080
```

#### **Step 4: Expose Services with Ngrok**

**Terminal 1 - Expose Laravel API:**
```bash
ngrok http 8000
```
Note the ngrok URL (e.g., `https://abc123.ngrok.io`)

**Terminal 2 - Expose USSD Server:**
```bash
ngrok http 8080
```
Note the ngrok URL (e.g., `https://def456.ngrok.io`)

#### **Step 5: Update Configuration**
Update `config.php` with your Laravel API ngrok URL:
```php
define('API_BASE_URL', 'https://abc123.ngrok.io/api');
```

#### **Step 6: Configure Africa's Talking**
1. Login to Africa's Talking Dashboard
2. Go to USSD section
3. Create new USSD application:
   - **Service Code:** `*384*123#` (or your preferred code)
   - **Callback URL:** `https://def456.ngrok.io/index.php`
   - **HTTP Method:** `POST`

#### **Step 7: Test Your USSD**
1. Dial your USSD code on your phone
2. Follow the menu prompts
3. Use test credentials: `guardian1@example.com` / `password123`

### Test Flow Examples

#### **Test Flow 1 - Check Immunization Status:**
1. Dial `*384*123#`
2. Select `1` (Check immunization status)
3. Enter `guardian1@example.com` (email address)
4. Enter `password123` (password)
5. You should see immunization status for David's children

#### **Test Flow 2 - List Children:**
1. Dial `*384*123#`
2. Select `2` (List my children)
3. Enter `guardian1@example.com` (email address)
4. Enter `password123` (password)
5. You should see David's children with patient IDs

#### **Test Flow 3 - View Vaccination History:**
1. Dial `*384*123#`
2. Select `3` (View vaccination history)
3. Enter `guardian1@example.com` (email address)
4. Enter `password123` (password)
5. You should see vaccination history

#### **Test Flow 4 - Health Facilities:**
1. Dial `*384*123#`
2. Select `5` (Health facilities)
3. You should see list of health facilities (no authentication required)

### Testing Checklist

1. ✅ Test each menu option with valid credentials
2. ✅ Test error scenarios (invalid credentials, network issues)
3. ✅ Verify phone number formatting
4. ✅ Test with different user roles
5. ✅ Test with different email addresses (guardian1@example.com, guardian2@example.com, etc.)

## Troubleshooting

### Common Issues

1. **Authentication Fails**: Check phone number format and API connectivity
2. **No Data Returned**: Verify user has children registered in the system
3. **API Errors**: Check Laravel API logs and USSD error logs

### Debug Mode

Enable debug logging by checking the error logs:
```bash
tail -f /var/log/apache2/error.log
# or
tail -f /var/log/nginx/error.log
```

## Support

For technical support or questions about the USSD implementation, please refer to the Laravel API documentation or contact the development team.
