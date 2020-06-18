---
title: API Reference

language_tabs:
- javascript

includes:

search: true

toc_footers:
- <a href='http://github.com/mpociot/documentarian'>Documentation Powered by Documentarian</a>
---
<!-- START_INFO -->
# Info

Welcome to the generated API reference.
[Get Postman Collection](http://localhost/docs/collection.json)

<!-- END_INFO -->

#Authentication

APIs for authentication
<!-- START_a925a8d22b3615f12fca79456d286859 -->
## Login

Get a JWT via given credentials.

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/auth/login"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "email": "me@example.comciw",
    "password": "12345678"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "access_token": "",
    "token_type": "bearer",
    "expires_in": 3600
}
```
> Example response (401):

```json
{
    "message": "登录验证失败"
}
```

### HTTP Request
`POST api/auth/login`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `email` | string |  required  | The email of the user.
        `password` | string |  required  | The password of the user.
    
<!-- END_a925a8d22b3615f12fca79456d286859 -->

<!-- START_2e1c96dcffcfe7e0eb58d6408f1d619e -->
## Register

Register user from api request

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/auth/register"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "username": "demo",
    "password": "12345678",
    "email": "me@example.com",
    "sex": 0,
    "age": 24
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "注册成功"
}
```

### HTTP Request
`POST api/auth/register`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `username` | string |  required  | The username of the user.
        `password` | string |  required  | The password of the user.
        `email` | string |  required  | The email of the user.
        `sex` | integer |  required  | The sex of the user.
        `age` | integer |  required  | The age of the user.
    
<!-- END_2e1c96dcffcfe7e0eb58d6408f1d619e -->

<!-- START_19ff1b6f8ce19d3c444e9b518e8f7160 -->
## Logout

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/auth/logout"
);


fetch(url, {
    method: "POST",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "message": "登出成功"
}
```

### HTTP Request
`POST api/auth/logout`


<!-- END_19ff1b6f8ce19d3c444e9b518e8f7160 -->

<!-- START_994af8f47e3039ba6d6d67c09dd9e415 -->
## Refresh token

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/auth/refresh"
);


fetch(url, {
    method: "POST",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "access_token": "",
    "token_type": "bearer",
    "expires_in": 3600
}
```

### HTTP Request
`POST api/auth/refresh`


<!-- END_994af8f47e3039ba6d6d67c09dd9e415 -->

<!-- START_a47210337df3b4ba0df697c115ba0c1e -->
## Me

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/auth/me"
);


fetch(url, {
    method: "POST",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 2,
    "created_at": null,
    "updated_at": null,
    "type": 0,
    "username": "example",
    "sex": 0,
    "age": 0,
    "head_portrait": null,
    "clinic": null,
    "mobile": null,
    "email": "me@example.com",
    "fixphonenumber": null,
    "certificat": null,
    "certificat_checked": null,
    "wechat": null,
    "intro": null,
    "school": null,
    "major": null
}
```

### HTTP Request
`POST api/auth/me`


<!-- END_a47210337df3b4ba0df697c115ba0c1e -->

#Clinic

Public APIs for getting clinic info.
<!-- START_49d6a3543680fabc28f79cd1087e1a6d -->
## Get clinics
Get clinic list

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/open/clinic"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "created_at": null,
            "updated_at": null,
            "name": "达明口腔门诊部",
            "city": "广州",
            "image": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
            "position": "23.544983,113.595114",
            "address": "广州市从化区河东北路5号",
            "intro": "暂无介绍"
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/open\/clinic?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/open\/clinic?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/open\/clinic",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/open/clinic`


<!-- END_49d6a3543680fabc28f79cd1087e1a6d -->

<!-- START_5b3f2d0d0376b72e6d56ee0eb6516f90 -->
## Get clinic
Get clinic by id

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/open/clinic/earum"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "created_at": null,
    "updated_at": null,
    "name": "达明口腔门诊部",
    "city": "广州",
    "image": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
    "position": "23.544983,113.595114",
    "address": "广州市从化区河东北路5号",
    "intro": "暂无介绍"
}
```

### HTTP Request
`GET api/open/clinic/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the clinic

<!-- END_5b3f2d0d0376b72e6d56ee0eb6516f90 -->

#Doctor

APIs for Doctor
<!-- START_5e3f194cbdab5f40a96adca0e87b3d7c -->
## Get certificate

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/certificate"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/doctor/certificate`


<!-- END_5e3f194cbdab5f40a96adca0e87b3d7c -->

<!-- START_9c8a0122d4d5be39c35086fa347ddfa1 -->
## Upload certificate

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/certificate/upload"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "certificate": "natus"
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/doctor/certificate/upload`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `certificate` | binary |  required  | The file of certificate image.
    
<!-- END_9c8a0122d4d5be39c35086fa347ddfa1 -->

<!-- START_4b5b3a4e7e45af7dae9e7c5936895f79 -->
## Get clinic

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/clinic"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "created_at": null,
    "updated_at": null,
    "name": "达明口腔门诊部",
    "city": "广州",
    "position": "113.595114,23.544983",
    "intro": "暂无介绍"
}
```

### HTTP Request
`GET api/doctor/clinic`


<!-- END_4b5b3a4e7e45af7dae9e7c5936895f79 -->

<!-- START_7140b674bc982c59a90378b528a6f925 -->
## Get Patients

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patient"
);

let params = {
    "page": "1",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": "DLE200617083554",
            "created_at": null,
            "updated_at": null,
            "name": "某人",
            "age": 10,
            "sex": 0,
            "comments": "无"
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/doctor\/patient?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/doctor\/patient?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/doctor\/patient",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/doctor/patient`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `page` |  optional  | The page number to return.

<!-- END_7140b674bc982c59a90378b528a6f925 -->

<!-- START_56aad3ae84439bb6bc85780542833e78 -->
## Get Patient

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patient/DLE200617083554"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": "DLE200617083554",
    "created_at": null,
    "updated_at": null,
    "name": "某人",
    "age": 10,
    "sex": 0,
    "comments": "无",
    "patient_cases": [
        {
            "id": 1,
            "created_at": null,
            "updated_at": null,
            "patient_id": "DLE200617083554",
            "user_id": 2,
            "state": 2,
            "features": "无症状",
            "files": "{}",
            "therapy_program": "无需治疗"
        }
    ]
}
```

### HTTP Request
`GET api/doctor/patient/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the case.

<!-- END_56aad3ae84439bb6bc85780542833e78 -->

<!-- START_23bc824a9562eb9873b6ae7e5d042322 -->
## Create patient

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patient"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "someone",
    "age": 24,
    "sex": 0,
    "comments": "Some content."
}

fetch(url, {
    method: "POST",
    headers: headers,
    body: body
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`POST api/doctor/patient`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | The name of the patient.
        `age` | integer |  required  | The age of the patient.
        `sex` | integer |  required  | The sex of the patient.
        `comments` | string |  required  | The comments of the patient.
    
<!-- END_23bc824a9562eb9873b6ae7e5d042322 -->

<!-- START_555c845d7e367546dd34081c14d0a491 -->
## Get cases

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "created_at": null,
            "updated_at": null,
            "patient_id": "DLE200617083554",
            "user_id": 2,
            "state": 2,
            "features": "无症状",
            "files": "{}",
            "therapy_program": "无需治疗"
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/doctor\/patientCase?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/doctor\/patientCase?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/doctor\/patientCase",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/doctor/patientCase`


<!-- END_555c845d7e367546dd34081c14d0a491 -->

<!-- START_4bed066ce46b16ab75eb1801478c9174 -->
## Get case

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase/a"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "created_at": null,
    "updated_at": null,
    "patient_id": "DLE200617083554",
    "user_id": 2,
    "state": 2,
    "features": "无症状",
    "files": "{}",
    "therapy_program": "无需治疗",
    "orders": [
        {
            "id": 1,
            "created_at": null,
            "updated_at": null,
            "clinic_id": 1,
            "professor_id": 1,
            "doctor_id": 2,
            "patient_case_id": 1,
            "is_first": 1,
            "state": 0,
            "product_count": 0,
            "product_amount_total": null,
            "order_amount_total": null,
            "logistics_fee": null,
            "address_id": 1,
            "logistics_no": null,
            "pay_channel": null,
            "pay_no": null,
            "delivery_time": null,
            "pay_time": null,
            "order_settlement_status": null,
            "order_settlement_time": null,
            "fapiao_id": null,
            "comments": "无备注"
        }
    ]
}
```

### HTTP Request
`GET api/doctor/patientCase/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the case

<!-- END_4bed066ce46b16ab75eb1801478c9174 -->

<!-- START_ff11b8c6f70c4d81bf372cc58c5ba000 -->
## Get orders

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order"
);

let params = {
    "page": "1",
};
Object.keys(params)
    .forEach(key => url.searchParams.append(key, params[key]));


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "current_page": 1,
    "data": [
        {
            "id": 1,
            "created_at": null,
            "updated_at": null,
            "clinic_id": 1,
            "professor_id": 1,
            "doctor_id": 2,
            "patient_case_id": 1,
            "is_first": 1,
            "state": 0,
            "product_count": 0,
            "product_amount_total": null,
            "order_amount_total": null,
            "logistics_fee": null,
            "address_id": 1,
            "logistics_no": null,
            "pay_channel": null,
            "pay_no": null,
            "delivery_time": null,
            "pay_time": null,
            "order_settlement_status": null,
            "order_settlement_time": null,
            "fapiao_id": null,
            "comments": "无备注"
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/doctor\/order?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/doctor\/order?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/doctor\/order",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/doctor/order`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `page` |  optional  | Page of the request.

<!-- END_ff11b8c6f70c4d81bf372cc58c5ba000 -->

<!-- START_c90b2590e8f65d2cdb6d50d1ea4a1c33 -->
## Get order by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order/1"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```


> Example response (200):

```json
{
    "id": 1,
    "created_at": null,
    "updated_at": null,
    "clinic_id": 1,
    "professor_id": 1,
    "doctor_id": 2,
    "patient_case_id": 1,
    "is_first": 1,
    "state": 0,
    "product_count": 0,
    "product_amount_total": null,
    "order_amount_total": null,
    "logistics_fee": null,
    "address_id": 1,
    "logistics_no": null,
    "pay_channel": null,
    "pay_no": null,
    "delivery_time": null,
    "pay_time": null,
    "order_settlement_status": null,
    "order_settlement_time": null,
    "fapiao_id": null,
    "comments": "无备注",
    "order_detail": [
        {
            "id": 1,
            "created_at": null,
            "updated_at": null,
            "order_id": 1,
            "product_no": "XXSD02",
            "product_name": "器具",
            "product_params": "{\"size\": 0}",
            "product_count": 2,
            "product_price": 20,
            "customer_comments": "无备注"
        }
    ]
}
```

### HTTP Request
`GET api/doctor/order/{id}`


<!-- END_c90b2590e8f65d2cdb6d50d1ea4a1c33 -->

#Management

APIs for Management
<!-- START_5a871f557e56944e43c2995b83e7ee9b -->
## Get all users

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/management/user"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/management/user`


<!-- END_5a871f557e56944e43c2995b83e7ee9b -->

<!-- START_5c64d602e9b6db7f5e9ae2ebbd1e794a -->
## Get user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/management/user/voluptatem"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/management/user/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the user

<!-- END_5c64d602e9b6db7f5e9ae2ebbd1e794a -->

<!-- START_85b26dfb7c0629679f8d09667a72a8b1 -->
## Get all clinic

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/management/clinic"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/management/clinic`


<!-- END_85b26dfb7c0629679f8d09667a72a8b1 -->

<!-- START_a867e88b69e1796806dcd6bc4ad72d81 -->
## Get clinic

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/management/clinic/nam"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/management/clinic/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the clinic

<!-- END_a867e88b69e1796806dcd6bc4ad72d81 -->

<!-- START_1360ec9f315bee8c1c4899c57a9b9b51 -->
## Get all order

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/management/order"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/management/order`


<!-- END_1360ec9f315bee8c1c4899c57a9b9b51 -->

<!-- START_61c49863786f10cddcc25fb7d05e86d7 -->
## Get order

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/management/order/error"
);


fetch(url, {
    method: "GET",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`GET api/management/order/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the order

<!-- END_61c49863786f10cddcc25fb7d05e86d7 -->


