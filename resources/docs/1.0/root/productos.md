# Productos


---


- [product/create-or-update/](#productcreate-or-update)


- [/service/{service_id}/product/create-or-update/](#serviceservice-idproductcreate-or-update)


- [/product/delete/](#productdelete)


- [/service/{service_id}/product/delete/](#serviceservice-idproductdelete)


<a name="productcreate-or-update"></a>
## product/create-or-update

Crear o actualizar productos masivamente
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`POST`|`\api/v1/product/create-or-update`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` product_code`|` json`|` required`|` Product_code `|
|` catalog_code`|` json`|` required`|` Catalog_code `|



>{info} Example Body Json
Content

```json
{"product_code":"ML-123","catalog_code":"catalogo 456",
    "product_data":{
        "title":"De la pobreza al éxito",
        "price": [
            {"value": "100.20", "currency": "ARS", "currencyType": null, "discountValue": null},
            {"value": "50.60", "currency": "BRL", "currencyType": null, "discountValue": null}
        ],
        "available_quantity":20,
        "buying_mode":"buy_it_now",
        "condition":"new",
        "description":{
            "plain_text":"Description"
        },
        "category": {
            "es": {"slug": "libros", "name": "Libros"},
            "pt": {"slug": "livros", "name": "Livros"}
        },
        "pictures":[
            {"source":"https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/mediamodifier97ded40e2a4.jpg"},
            {"source":"https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/9789874743664.jpg"}
        ],
        "listing_type": "3",
        "attributes": {

            "productFormat": "Tapa blanda o bolsillo",
            "gender": {
                "es": "Autoayuda",
                "pt": "Autoajuda"
            },
            "subgender":{
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
            "format":"papel"

        },
        "sizes": {
            "width": 15,
            "height": 20,
            "depth": 2,
            "weight": 1
        },
        "shippingOptions": {
            "declaredPrice": 200
        }

    }
}
```



> {success} Example Success Response
Code `200`

Content

```json
  [{"status":"ok"}]
```

>{danger} Example Error Response

Content
```json
    
[{"1233":{"status":"error","message":"faltan datos requeridos"}}]
    
```




<a name="serviceservice-idproductcreate-or-update"></a>
## /service/{service_id}/product/create-or-update

Crear o actualizar productos masivamente segun el servicio
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`POST`|`\api/v1/service/{service_id}/product/create-or-update`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` product_code`|` json`|` required`|` Product_code `|
|` catalog_code`|` json`|` required`|` Catalog_code `|

>{info} Example Body Json
Content

```json
{"product_code":"ML-123","catalog_code":"catalogo 456",
    "product_data":{
        "title":"De la pobreza al éxito",
        "price": [
            {"value": "100.20", "currency": "ARS", "currencyType": null, "discountValue": null},
            {"value": "50.60", "currency": "BRL", "currencyType": null, "discountValue": null}
        ],
        "available_quantity":20,
        "buying_mode":"buy_it_now",
        "condition":"new",
        "description":{
            "plain_text":"Description"
        },
        "category": {
            "es": {"slug": "libros", "name": "Libros"},
            "pt": {"slug": "livros", "name": "Livros"}
        },
        "pictures":[
            {"source":"https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/mediamodifier97ded40e2a4.jpg"},
            {"source":"https://data.livriz.com/media/MediaSpace/F9AFB48D-741D-4834-B760-F59344EEFF34/4/90519236-7a8a-4c6e-bb6b-860c92317935/9789874743664.jpg"}
        ],
        "listing_type": "3",
        "attributes": {

            "productFormat": "Tapa blanda o bolsillo",
            "gender": {
                "es": "Autoayuda",
                "pt": "Autoajuda"
            },
            "subgender":{
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
            "format":"papel"

        },
        "sizes": {
            "width": 15,
            "height": 20,
            "depth": 2,
            "weight": 1
        },
        "shippingOptions": {
            "declaredPrice": 200
        }

    }
}
```



> {success} Example Success Response
Code `200`

Content

```json
  [{"status":"ok"}]
```

>{danger} Example Error Response

Content
```json
    
[{"1233":{"status":"error","message":"faltan datos requeridos"}}]
    
```

<a name="productdelete"></a>
## /product/delete/

Borrar productos masivamente.
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`DELETE`|`\api/v1/product/delete`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` service_id`|` number`|` required`|` Borrar productos para todos los servicios`|

>{info} Example Body Json

Content
```json
{"product_code":"SKU o ISBN","catalog_code":"catalogo 2",
	"product_data":{
		"data": "OPTIONAL"
	}
}
```

> {success} Example Success Response
Code `200`

Content

```json
{
    "status":"ok"
}

```



<a name="serviceservice-idproductdelete"></a>
## /service/{service_id}/product/delete

Borrar productos segun el servicio.
### Endpoint
|Method|URI|Authentication|
|:-|:-|:-|
|`DELETE`|`\api/v1/service/{service_id}/product/delete/`|`true`|


### Body Params
|Name|Type|Status|Description|
|:-|:-|:-|:-|
|` service_id`|` number`|` required`|` Borrar productos segun el servicio`|

>{info} Example Body Json

Content
```json
{"product_code":"SKU o ISBN","catalog_code":"catalogo 2",
	"product_data":{
		"data": "OPTIONAL"
	}
}
```

> {success} Example Success Response
Code `200`

Content

```json
{
    "status":"ok"
}

```


