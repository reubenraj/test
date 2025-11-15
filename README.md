# Pastor Connect - Social Platform for Pastors

A comprehensive social platform designed to connect pastors with each other, enabling fellowship, knowledge sharing, and mutual support.

## Features

### Authentication
- User Registration
- Login/Logout
- Forgot Password & Password Reset
- JWT Token-based Authentication (Laravel Sanctum)

### Pastor Profile Management
- Personal Details (name, email, phone, address)
- Church & Denomination Information
- Ordination Status and Date
- Bio and Profile Image
- Education History (institution, degree, field of study, dates)
- Work Experience (previous church positions, responsibilities)

### Networking & Connections
- Browse Pastor Directory
- Follow/Unfollow Pastors
- View Followers and Following Lists
- Connect with Pastors Worldwide

### Messaging System
- Direct Messaging Between Pastors
- Conversation History
- Read/Unread Status
- Real-time Message Notifications

### Sermon Sharing
- Create and Publish Sermons
- Scripture References
- Sermon Series Organization
- Tags for Easy Discovery
- Draft/Published Status
- Browse All Published Sermons

### Prayer Requests
- Submit Prayer Requests (Public or Anonymous)
- Reply to Prayer Requests
- Update Prayer Request Status (Open, Answered, Closed)
- Community Prayer Support

## Tech Stack

### Backend
- **PHP 8.4** with **Laravel 12.0**
- **Laravel Sanctum** for API authentication
- **MySQL/SQLite** for database
- RESTful API architecture

### Frontend
- **Vue.js 3** (Composition API)
- **Vuetify 3** for UI components
- **Vue Router 4** for navigation
- **Pinia** for state management
- **Axios** for HTTP requests
- **Vite** for build tooling

## Project Structure

```
pastor-connect/
├── pastor-connect-backend/    # Laravel API Backend
│   ├── app/
│   │   ├── Http/Controllers/API/
│   │   └── Models/
│   ├── database/migrations/
│   ├── routes/api.php
│   └── ...
│
└── pastor-connect-frontend/   # Vue.js Frontend
    ├── src/
    │   ├── views/
    │   ├── components/
    │   ├── stores/
    │   ├── services/
    │   ├── router/
    │   └── plugins/
    └── ...
```

## Installation & Setup

### Prerequisites
- PHP 8.4 or higher
- Composer
- Node.js 18+ and npm
- MySQL or SQLite

### Backend Setup

1. Navigate to the backend directory:
   ```bash
   cd pastor-connect-backend
   ```

2. Install PHP dependencies:
   ```bash
   composer install
   ```

3. Copy environment file:
   ```bash
   cp .env.example .env
   ```

4. Configure your database in `.env`:
   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=pastor_connect
   DB_USERNAME=your_username
   DB_PASSWORD=your_password
   ```

   Or for SQLite (simpler for development):
   ```env
   DB_CONNECTION=sqlite
   DB_DATABASE=/absolute/path/to/database.sqlite
   ```

5. Generate application key:
   ```bash
   php artisan key:generate
   ```

6. Run database migrations:
   ```bash
   php artisan migrate
   ```

7. Start the Laravel development server:
   ```bash
   php artisan serve
   ```

   The API will be available at `http://localhost:8000`

### Frontend Setup

1. Navigate to the frontend directory:
   ```bash
   cd pastor-connect-frontend
   ```

2. Install npm dependencies:
   ```bash
   npm install
   ```

3. Configure API URL in `.env`:
   ```env
   VITE_API_URL=http://localhost:8000/api
   ```

4. Start the development server:
   ```bash
   npm run dev
   ```

   The frontend will be available at `http://localhost:5173`

## API Endpoints

### Authentication
- `POST /api/register` - Register new user
- `POST /api/login` - User login
- `POST /api/logout` - User logout (requires auth)
- `POST /api/forgot-password` - Send password reset link
- `POST /api/reset-password` - Reset password
- `GET /api/user` - Get authenticated user (requires auth)

### Pastor Profiles
- `GET /api/profiles` - Get all profiles
- `POST /api/profiles` - Create/Update profile
- `GET /api/profiles/{id}` - Get specific profile
- `GET /api/profile/my-profile` - Get current user's profile

### Education
- `GET /api/educations` - Get user's education
- `POST /api/educations` - Add education
- `PUT /api/educations/{id}` - Update education
- `DELETE /api/educations/{id}` - Delete education

### Work Experience
- `GET /api/work-experiences` - Get user's work experience
- `POST /api/work-experiences` - Add work experience
- `PUT /api/work-experiences/{id}` - Update work experience
- `DELETE /api/work-experiences/{id}` - Delete work experience

### Following/Followers
- `GET /api/pastors` - Get all pastors
- `POST /api/follow/{userId}` - Follow a pastor
- `DELETE /api/unfollow/{userId}` - Unfollow a pastor
- `GET /api/followers` - Get followers
- `GET /api/following` - Get following

### Messages
- `GET /api/messages` - Get all messages
- `GET /api/messages/conversations` - Get conversation partners
- `GET /api/messages/conversation/{userId}` - Get conversation with specific user
- `POST /api/messages` - Send message
- `GET /api/messages/unread-count` - Get unread message count

### Sermons
- `GET /api/sermons` - Get all published sermons
- `GET /api/sermons/my-sermons` - Get user's sermons
- `POST /api/sermons` - Create sermon
- `GET /api/sermons/{id}` - Get specific sermon
- `PUT /api/sermons/{id}` - Update sermon
- `DELETE /api/sermons/{id}` - Delete sermon

### Prayer Requests
- `GET /api/prayer-requests` - Get all prayer requests
- `GET /api/prayer-requests/my-requests` - Get user's prayer requests
- `POST /api/prayer-requests` - Create prayer request
- `GET /api/prayer-requests/{id}` - Get specific prayer request
- `PUT /api/prayer-requests/{id}` - Update prayer request
- `DELETE /api/prayer-requests/{id}` - Delete prayer request
- `PATCH /api/prayer-requests/{id}/status` - Update status

### Prayer Request Replies
- `POST /api/prayer-requests/{id}/replies` - Add reply
- `PUT /api/prayer-request-replies/{id}` - Update reply
- `DELETE /api/prayer-request-replies/{id}` - Delete reply

## Development

### Running Tests
```bash
# Backend
cd pastor-connect-backend
php artisan test

# Frontend
cd pastor-connect-frontend
npm run test
```

### Building for Production

#### Backend
```bash
composer install --optimize-autoloader --no-dev
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### Frontend
```bash
npm run build
```

## Database Schema

### Users Table
- id, name, first_name, last_name, email, password, phone (nullable), address (nullable)

### Pastor Profiles Table
- id, user_id, current_church_name, current_church_address, denomination, ordination_status, ordination_date, bio, profile_image

### Educations Table
- id, user_id, institution_name, degree, field_of_study, start_date, end_date, description

### Work Experiences Table
- id, user_id, church_name, position, location, start_date, end_date, is_current, responsibilities

### Follows Table
- id, follower_id, following_id

### Messages Table
- id, sender_id, receiver_id, message, is_read, read_at

### Sermons Table
- id, user_id, title, scripture_reference, content, preached_date, sermon_series, tags, is_published

### Prayer Requests Table
- id, user_id, title, description, status, is_anonymous

### Prayer Request Replies Table
- id, prayer_request_id, user_id, reply

## Security Features

- Password hashing with bcrypt
- CSRF protection
- SQL injection prevention through Eloquent ORM
- XSS protection
- API authentication with Laravel Sanctum
- Input validation and sanitization
- Secure password reset functionality

## Future Enhancements

- Real-time chat with WebSockets
- Video conferencing integration
- Event management system
- Resource library
- Mobile applications (iOS & Android)
- Multi-language support
- Advanced search and filtering
- Notifications system
- File attachments in messages
- Sermon audio/video uploads

## Contributing

Contributions are welcome! Please feel free to submit a Pull Request.

## License

This project is open-source and available under the MIT License.

## Support

For support, please open an issue in the GitHub repository or contact the development team.

---

Built with ❤️ for the pastoral community
