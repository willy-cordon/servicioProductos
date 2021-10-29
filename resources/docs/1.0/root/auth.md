# Authentication

Login para poder operar con los endpoints

---

- [Login](#Login)



<a name="serviceservice-idorders"></a>
## Login


### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`POST`|`/api/v1/login`|`false`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` email`|` string`|` required`|` Email del usuario`|
|` password`|` string`|` required`|` Contraseña del usuario`|




> {success} Example Success Response
Code `200`

Content

```json
{
    "token_type": "Bearer",
    "abilities": [
        "api-users-read"
    ],
    "expires_in": -1,
    "access_token": "QHaqvNIA3PZ7yoTimYLx7cOgPbtt0QTyckUbV67I"
}

```
