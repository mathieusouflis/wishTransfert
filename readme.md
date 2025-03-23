# WishTransfert

## Description
WishTransfert is a file sharing application that allows users to securely upload, store, and share files with others. It provides a simple and intuitive interface for transferring files, with features like email-restricted downloads, file management, and user authentication.

## Essential Features
- **User Authentication**: Secure login and registration system
- **File Upload**: Support for uploading multiple files with size limits
- **File Sharing**: Generate unique links to share files with others
- **Email Restrictions**: Restrict file downloads to specific email addresses
- **Download Management**: Track download counts and manage file access
- **User Dashboard**: Manage uploaded files and sharing links
- **Responsive Design**: Works on desktop and mobile devices

## Docker Setup

### Prerequisites
- Docker and Docker Compose installed on your system

### Running the Application

1. Clone the repository:
```bash
git clone https://github.com/mathieusouflis/wishTransfert.git
cd wishtransfert
```

2. Start the application using Docker Compose:
```bash
docker compose up -d
```

3. Access the application:
   - Web Application: http://localhost:8888
   - phpMyAdmin: http://localhost:8081 (username: root, password: root)

4. To stop the application:
```bash
docker compose down
```

### Rebuilding the Application
If you make changes to the code or configuration, rebuild the containers:
```bash
docker compose down
docker compose up -d --build
```

### Resetting the Database
To completely reset the database and recreate all tables:
```bash
docker compose down -v
docker compose up -d
```

## Development
The application is built using PHP with a MySQL database. The project structure follows an MVC-like pattern with controllers, models, and views separated for better organization.
