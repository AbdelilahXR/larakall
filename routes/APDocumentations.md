# API Documentation

### Login
- **URL:** `/api/login`
- **Method:** `POST`
- **Description:** Login to the system
- **Request:**
  - **Body:**
    - `email` (string): User email
    - `password` (string): User password
- **Response:**
    - **Body:**
        ```
        {
            "data": {
                "id": 2,
                "name": "client",
                "fullName_ar": null,
                "fullName_fr": null,
                "fullName_en": null,
                "email": "client@gmail.com",
                "phone1": null,
                "phone2": null,
                "city": null,
                "avatar_url": "",
                "status": null,
                "addition": null,
                "reference": null,
                "roles": [
                    "client"
                ],
                "stores": [
                    {
                        "id": 1,
                        "name": "test",
                        "status": 1,
                        "has_google_sheet": 0,
                        "adding_order_type": "import_from_excel",
                        "created_at": "2024-04-09T21:37:51.000000Z",
                        "updated_at": "2024-04-12T17:12:20.000000Z",
                        "deleted_at": null,
                        "users_id": 2,
                        "google_sheets_id": null
                    },
                    {
                        "id": 3,
                        "name": "test 2",
                        "status": 1,
                        "has_google_sheet": 0,
                        "adding_order_type": "insert_orders_manually",
                        "created_at": "2024-05-17T20:01:03.000000Z",
                        "updated_at": "2024-05-17T20:01:03.000000Z",
                        "deleted_at": null,
                        "users_id": 2,
                        "google_sheets_id": null
                    }
                ]
            },
            "access_token": "9|UXTHaccOOTS1L3HvdG8uiIYas7H5uBG9h2XN1XYn78eff9ac",
            "token_type": "Bearer"
        }
        ```
- **Error Response:**
    - **Body:**
        ```	
        {
            "errors": {
                "email": [
                    "The email field is required."
                ],
                "password": [
                    "The password field is required."
                ]
            }
        }
        ```

### Logout
- **URL:** `/api/logout`
- **Method:** `POST`
- **Description:** Logout from the system
- **Request:**
  - **Body:**
    ```
    {}
    ```
- **Response:**
    - **Body:**
        ```	
        {
            "message": "You have been successfully logged out."
        }
        ```


### Stores List
- **URL:** `/api/client/stores`
- **Method:** `GET`
- **Description:** Get all stores
- **Request:**
  - **Body:**
    ```
    {}
    ```
- **Response:**
    - **Body:**
        ```	
        [
            {
                "id": 1,
                "name": "test",
                "status": 1,
                "has_google_sheet": 0,
                "adding_order_type": "import_from_excel",
                "created_at": "2024-04-09T21:37:51.000000Z",
                "updated_at": "2024-04-12T17:12:20.000000Z",
                "deleted_at": null,
                "users_id": 2,
                "google_sheets_id": null
            }
        ]
        ```
- **Error Response:**
    - **Body:**
        ```	
        {
            "message": "Unauthenticated."
        }
        ```


### Statistics
- **URL:** `/api/client/statistics`
- **Method:** `GET`
- **Description:** Get all stores
- **Request:**
  - **Body:**
    ```
    {}
    ```
- **Response:**
    - **Body:**
        ```
        {
            "shipped": {
                "type": "delivery",
                "color": null,
                "sum": 0,
                "count": 0
            },
            "delivered": {
                "type": "delivery",
                "color": null,
                "sum": 0,
                "count": 0
            },
            "canceled": {
                "type": "confirmation",
                "color": null,
                "sum": 0,
                "count": 0
            },
            "new": {
                "type": "confirmation",
                "color": "#007aff",
                "sum": 0,
                "count": 0
            }
        }
        ```

### Orders
- **URL:** `/api/client/orders`
- **Method:** `get`
- **Description:** Client Orders
- **Request:**
  - **Body:**
    - `store` (int): Store ID
    - `from` (string): YYYY-MM-DD
    - `to` (string): YYYY-MM-DD
- **Response:**
    - **Body:**
        ```
        {
            "id": 1,
            "code": "O-24412AHN7",
            "reference": "2",
            "client": "name of client",
            "phone": "0675406152",
            "price": 250,
            "city": "agadir salam",
            "adress": "agadir salam",
            "information": null,
            "updated_at": "2024-04-12T17:14:26.000000Z",
            "deleted_at": null,
            "created_at": "2024-05-17T17:13:24.000000Z",
            "shipping_company_id": null,
            "shipping_company_name": null,
            "tracking_code": null,
            "store_id": 1,
            "store_name": "test",
            "confirmation_state": "New",
            "delivery_state": null,
            "products": [
                {
                    "id": 5,
                    "name": "blue",
                    "script": null,
                    "type": "variant",
                    "upsell": [],
                    "image_1": null,
                    "image_2": null,
                    "image_3": null,
                    "link": "vddddddddddd.com",
                    "description": null,
                    "min_price": 120,
                    "max_price": 125,
                    "created_at": "2024-04-01T21:08:55.000000Z",
                    "updated_at": "2024-04-12T17:11:47.000000Z",
                    "deleted_at": null,
                    "stores_id": 1,
                    "parent_id": 1,
                    "pivot": {
                        "orders_id": 1,
                        "products_id": 5,
                        "quantity": 1,
                        "unit_price": 150
                    }
                },
                {
                    "id": 4,
                    "name": "red",
                    "script": null,
                    "type": "variant",
                    "upsell": [],
                    "image_1": null,
                    "image_2": null,
                    "image_3": null,
                    "link": "vddddddddddd.com",
                    "description": null,
                    "min_price": 120,
                    "max_price": 125,
                    "created_at": "2024-04-01T21:08:55.000000Z",
                    "updated_at": "2024-04-12T17:11:47.000000Z",
                    "deleted_at": null,
                    "stores_id": 1,
                    "parent_id": 1,
                    "pivot": {
                        "orders_id": 1,
                        "products_id": 4,
                        "quantity": 1,
                        "unit_price": 100
                    }
                }
            ]
        }
        ```
