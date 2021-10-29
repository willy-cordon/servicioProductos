# API

Endpoints Livriz Market

---

- [services](#services)


- [service/{service_id}/product/create-or-update](#serviceservice-idproductcreate-or-update)


- [/service/{service_id}/product/create-or-update/bulk](#serviceservice-idproductcreate-or-updatebulk)


- [product/create-or-update/bulk](#productcreate-or-updatebulk)


- [service/{service_id}/product/delete](#serviceservice-idproductdelete)


- [product/delete](#productdelete)


- [/product/delete/bulk](#productdeletebulk)


- [/service/{service_id}/product/delete/bulk](#serviceservice-idproductdeletebulk)



<a name="services"></a>
## services

Consultar los servicios que tiene asociados la cuenta del usuario
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`GET`|`\api/v1/services`|`true`|




> {success} Example Success Response
Code `200`

Content

```json
{
    "id": 1,
    "name": "mercado libre"
}

```



<a name="serviceservice-idproductcreate-or-update"></a>
## service/{service_id}/product/create-or-update

Crear o actualizar producto para un determiando servicio
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`POST`|`\api/v1/service/{service_id}/product/create-or-update`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` service_id`|` number`|` required`|` Create or update product and service by service Id`|



> {success} Example Success Response
Code `200`

Content

```json
{
    "status":"ok"
}

```



<a name="serviceservice-idproductcreate-or-updatebulk"></a>
## /service/{service_id}/product/create-or-update/bulk

Crear o actualizar productos masivamente segun el servicio
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`POST`|`\api/v1/service/{service_id}/product/create-or-update/bulk`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` product_code`|` json`|` required`|` Product_code `|
|` catalog_code`|` json`|` required`|` Product_code `|



> {success} Example Success Response
Code `200`

Content

```json
{
    "product_code":"ML-000421","catalog_code":"catalogo 421",
    "product_data": {
        "title": "De la pobreza al éxito",
        "price": [
            {
                "value": "100.20",
                "currency": "ARS",
                "currencyType": null,
                "discountValue": null
            },
            {
                "value": "50.60",
                "currency": "BRL",
                "currencyType": null,
                "discountValue": null
            }
        ],
        "available_quantity": 20,
        "buying_mode": "buy_it_now",
        "condition": "new",
        "description": {
            "plain_text": "Description"
        },
        "category": {
            "es": {
                "slug": "libros",
                "name": "Libros"
            },
            "pt": {
                "slug": "livros",
                "name": "Livros"
            }
        },
        "pictures": [
            {
                "source": "https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/mediamodifier97ded40e2a4.jpg"
            },
            {
                "source": "https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/9789874743664.jpg"
            }
        ],
        "listing_type": "3",
        "attributes": {
            "productFormat": "Tapa blanda o bolsillo",
            "gender": {
                "es": "Autoayuda",
                "pt": "Autoajuda"
            },
            "subgender": {
                "es": "Desarrollo personal y consejos prácticos",
                "pt": "Desenvolvimento pessoal e conselhos práticos"
            },
            "productFormatDetail": "Trade paperback(EE.UU.)",
            "countryCode": "AR",
            "language": "spa",
            "publisher": "Del Fondo Editorial",
            "publicationDate": "20201211",
            "printer": "Valkiria",
            "author": "James Allen",
            "numberOfPieces": null,
            "numberOfPages": "180",
            "format": "papel"
        }
    }
}

```



<a name="productcreate-or-updatebulk"></a>
## product/create-or-update/bulk

Crear o actualizar productos masivamente
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`POST`|`\api/v1/product/create-or-update/bulk`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` product_code`|` json`|` required`|` Product_code `|
|` catalog_code`|` json`|` required`|` Product_code `|



> {success} Example Success Response
Code `200`

Content

```json
{
    "product_code":"ML-000421","catalog_code":"catalogo 421",
    "product_data": {
        "title": "De la pobreza al éxito",
        "price": [
            {
                "value": "100.20",
                "currency": "ARS",
                "currencyType": null,
                "discountValue": null
            },
            {
                "value": "50.60",
                "currency": "BRL",
                "currencyType": null,
                "discountValue": null
            }
        ],
        "available_quantity": 20,
        "buying_mode": "buy_it_now",
        "condition": "new",
        "description": {
            "plain_text": "Description"
        },
        "category": {
            "es": {
                "slug": "libros",
                "name": "Libros"
            },
            "pt": {
                "slug": "livros",
                "name": "Livros"
            }
        },
        "pictures": [
            {
                "source": "https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/mediamodifier97ded40e2a4.jpg"
            },
            {
                "source": "https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/9789874743664.jpg"
            }
        ],
        "listing_type": "3",
        "attributes": {
            "productFormat": "Tapa blanda o bolsillo",
            "gender": {
                "es": "Autoayuda",
                "pt": "Autoajuda"
            },
            "subgender": {
                "es": "Desarrollo personal y consejos prácticos",
                "pt": "Desenvolvimento pessoal e conselhos práticos"
            },
            "productFormatDetail": "Trade paperback(EE.UU.)",
            "countryCode": "AR",
            "language": "spa",
            "publisher": "Del Fondo Editorial",
            "publicationDate": "20201211",
            "printer": "Valkiria",
            "author": "James Allen",
            "numberOfPieces": null,
            "numberOfPages": "180",
            "format": "papel"
        }
    }
}

```



<a name="serviceservice-idproductdelete"></a>
## service/{service_id}/product/delete

Borrar producto de un determiado servicio.
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`DELETE`|`\api/v1/service/{service_id}/product/delete`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` service_id`|` number`|` required`|` Delete product by service id`|



> {success} Example Success Response
Code `200`

Content

```json
{
    "status":"ok"
}

```



<a name="productdelete"></a>
## product/delete

Borrar producto.
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`DELETE`|`\api/v1/product/delete`|`true`|




> {success} Example Success Response
Code `200`

Content

```json
{
    "product_code":"SKU-21212121","catalog_code":"catalogo 1"
}

```



<a name="productdeletebulk"></a>
## /product/delete/bulk

Borrar productos masivamente.
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`DELETE`|`\api/v1/product/delete/bulk`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` service_id`|` number`|` required`|` Delete product by service id`|



> {success} Example Success Response
Code `200`

Content

```json
{
    "status":"ok"
}

```



<a name="serviceservice-idproductdeletebulk"></a>
## /service/{service_id}/product/delete/bulk

Borrar productos segun el servicio.
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`DELETE`|`\api/v1/service/{service_id}/product/delete/bulk`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` service_id`|` number`|` required`|` Delete product by service id`|



> {success} Example Success Response
Code `200`

Content

```json
{
    "status":"ok"
}

```


