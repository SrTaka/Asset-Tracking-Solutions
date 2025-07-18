
### `docs/api.md`
```markdown
# API Documentation

## Authentication
`POST /api/auth/login`
```json
{
  "email": "test@gmail.com",
  "password": "password"
}


`POST /api/auth/admin/login`
```json
{
  "email": "user@example.com",
  "password": "password"
}


Endpoints

Users

Method	                            Endpoint	                                Description
POST	                            http://127.0.0.1:8000/register              Create new general user
POST	                            http://127.0.0.1:8000/login                 Login to existing general user
POST	                            http://127.0.0.1:8000/logout                Logout of current session


Admins

Method	                            Endpoint	                                Description
POST	                            http://127.0.0.1:8000/admin/register	    Create new admin user
POST	                            http://127.0.0.1:8000/admin/login           Login to existing admin user
POST	                            http://127.0.0.1:8000/admin/logout          Logout of current session
