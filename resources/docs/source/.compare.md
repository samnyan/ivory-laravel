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
Log the user out (Invalidate the token).

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
Refresh a token.

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
Get the authenticated User.

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

let params = {
    "name": "牙科医院",
    "city": "广州",
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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `name` |  optional  | Search clinic by name.
    `city` |  optional  | Filter clinic by city.
    `page` |  optional  | The page number to return.

<!-- END_49d6a3543680fabc28f79cd1087e1a6d -->

<!-- START_5b3f2d0d0376b72e6d56ee0eb6516f90 -->
## Get clinic
Get clinic by id

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/open/clinic/quas"
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
    "intro": "暂无介绍",
    "users": [
        {
            "clinic_id": 1,
            "username": "测试医生",
            "school": "没读大学",
            "major": "忽悠专业"
        }
    ]
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
<!-- START_9c8a0122d4d5be39c35086fa347ddfa1 -->
## Upload certificate
Form request for upload a certificate image

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
    "certificate": "voluptas"
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
Get clinic info of the user

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

<!-- START_81f2dadc7cee29b7b241b7993b80f82c -->
## Create clinic
Create clinic for this doctor if this doctor doesn&#039;t belong to any clinic

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/clinic"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "name": "\u8bca\u6240",
    "city": "\u5e7f\u5dde",
    "position": "23.544983,113.595114",
    "address": "\u5e7f\u5dde\u5e02\u4ece\u5316\u533a\u6cb3\u4e1c\u5317\u8def5\u53f7",
    "intro": "doloribus"
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
`POST api/doctor/clinic`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | The name of the clinic.
        `city` | string |  required  | The city of the clinic.
        `position` | string |  required  | The position of the clinic.
        `address` | string |  required  | The address of the clinic.
        `intro` | string |  required  | The description of the clinic.
    
<!-- END_81f2dadc7cee29b7b241b7993b80f82c -->

<!-- START_8f43702e94b14a4362ed25757cc71002 -->
## Upload clinic image
Upload clinic image with Form data, return the uploaded url.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/clinic/image"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "image": "et"
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
    "message": "上传成功",
    "path": "clinic\/xxx.jpg"
}
```

### HTTP Request
`POST api/doctor/clinic/image`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `image` | binary |  optional  | The image of the clinic.
    
<!-- END_8f43702e94b14a4362ed25757cc71002 -->

<!-- START_7140b674bc982c59a90378b528a6f925 -->
## Get patients
Get all patients created by this user.

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
            "created_at": "2020-06-26T13:33:58.000000Z",
            "updated_at": "2020-06-26T13:33:58.000000Z",
            "name": "某人",
            "age": 10,
            "sex": 0,
            "comments": "无",
            "photo_url": null,
            "patient_cases": [
                {
                    "id": 1,
                    "created_at": "2020-06-26T13:33:58.000000Z",
                    "updated_at": "2020-06-26T13:33:58.000000Z",
                    "patient_id": "DLE200617083554",
                    "user_id": 2,
                    "state": 2,
                    "features": "无症状",
                    "files": "{}",
                    "therapy_program": "无需治疗"
                }
            ]
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
## Get patient
Get patient by id.

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
Create a patient

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


> Example response (200):

```json
{
    "id": "0",
    "name": "某人",
    "age": 10,
    "sex": 0,
    "comments": "0",
    "updated_at": "2020-06-26T13:43:15.000000Z",
    "created_at": "2020-06-26T13:43:15.000000Z"
}
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

<!-- START_ea7df65a25936229cd65eaf106b1880a -->
## Update patient
Update patient detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patient/1"
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


> Example response (200):

```json
{
    "id": "0",
    "name": "某人",
    "age": 10,
    "sex": 0,
    "comments": "0",
    "updated_at": "2020-06-26T13:43:15.000000Z",
    "created_at": "2020-06-26T13:43:15.000000Z"
}
```

### HTTP Request
`POST api/doctor/patient/{id}`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `name` | string |  required  | The name of the patient.
        `age` | integer |  required  | The age of the patient.
        `sex` | integer |  required  | The sex of the patient.
        `comments` | string |  required  | The comments of the patient.
    
<!-- END_ea7df65a25936229cd65eaf106b1880a -->

<!-- START_4c783098a1bf9946dc4fae0de17da216 -->
## Upload patient photo
Form request for upload patient photo, this will also update photo_url filed

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patient/1/photo"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file": "aut"
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
    "message": "照片更新成功",
    "path": "patientPhoto\/DRUCjs92FfgYEXY0DFTa5OUSrivUADxqB4sxPopS.jpeg"
}
```

### HTTP Request
`POST api/doctor/patient/{id}/photo`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file` | binary |  required  | The file of patient photo.
    
<!-- END_4c783098a1bf9946dc4fae0de17da216 -->

<!-- START_555c845d7e367546dd34081c14d0a491 -->
## Get patient cases
Get all patient cases created by this user.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase"
);

let params = {
    "page": "1",
    "state": "0",
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
            "patient_id": "DLE200617083554",
            "user_id": 2,
            "state": 2,
            "features": "无症状",
            "files": "{}",
            "therapy_program": "无需治疗",
            "patient": {
                "id": "DLE200617083554",
                "created_at": null,
                "updated_at": null,
                "name": "某人",
                "age": 10,
                "sex": 0,
                "comments": "无"
            }
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

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `page` |  optional  | Page of the request.
    `state` |  optional  | The state of case (-1已取消 0创建 1资料已提交(医生) 2资料需修改 3方案已制定(专家) 4方案待修改 5方案已同意 6已确认 7已下单 8订单已确认 10已存档) .

<!-- END_555c845d7e367546dd34081c14d0a491 -->

<!-- START_4bed066ce46b16ab75eb1801478c9174 -->
## Get patient case
Get patient case by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase/1"
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
    "patient": {
        "id": "DLE200617083554",
        "created_at": null,
        "updated_at": null,
        "name": "某人",
        "age": 10,
        "sex": 0,
        "comments": "无"
    },
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
            "product_count": 3,
            "total_price": 1000,
            "payment_price": 998,
            "shipping_fee": 14,
            "pay_method": 1,
            "pay_number": "15233958572390",
            "pay_time": "2020-06-19 13:26:43",
            "tracking_number": "SF000002231231",
            "address_id": 1,
            "shipping_time": "2020-06-19 13:26:43",
            "fapiao_id": 1,
            "comments": "无备注"
        },
        {
            "id": 2,
            "created_at": "2020-06-20T02:55:40.000000Z",
            "updated_at": "2020-06-20T02:58:48.000000Z",
            "clinic_id": 1,
            "professor_id": 3,
            "doctor_id": 2,
            "patient_case_id": 1,
            "is_first": 0,
            "state": 0,
            "product_count": null,
            "total_price": 1.2,
            "payment_price": null,
            "shipping_fee": null,
            "pay_method": null,
            "pay_number": null,
            "pay_time": null,
            "tracking_number": null,
            "address_id": null,
            "shipping_time": null,
            "fapiao_id": null,
            "comments": "还行"
        }
    ]
}
```

### HTTP Request
`GET api/doctor/patientCase/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the case.

<!-- END_4bed066ce46b16ab75eb1801478c9174 -->

<!-- START_55980171f16cf1413462070a1734b09f -->
## Create patient case
Create a patient case base on a patient

> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "patient_id": "PAT0315091509",
    "features": "Some content."
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
    "patient_id": "DLE200617083554",
    "user_id": 2,
    "state": 0,
    "features": "Something",
    "updated_at": "2020-06-26T13:35:35.000000Z",
    "created_at": "2020-06-26T13:35:35.000000Z",
    "id": 3
}
```

### HTTP Request
`POST api/doctor/patientCase`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `patient_id` | string |  required  | The patient id.
        `features` | string |  required  | The patient case detail.
    
<!-- END_55980171f16cf1413462070a1734b09f -->

<!-- START_39dff5567a0a54c0d2d2d735d9b83847 -->
## Update patient case
Update the patient case detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "state": 1,
    "features": "Some content.",
    "files": "{photo1: '\/case\/1234.jpg'}."
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
    "id": 3,
    "created_at": "2020-06-26T13:35:35.000000Z",
    "updated_at": "2020-06-26T13:35:35.000000Z",
    "patient_id": "DLE200617083554",
    "user_id": 2,
    "state": 0,
    "features": "Something",
    "files": null,
    "therapy_program": null
}
```

### HTTP Request
`POST api/doctor/patientCase/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the case.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `state` | integer |  optional  | The state of this patient case.
        `features` | string |  optional  | The patient case detail.
        `files` | json |  optional  | The required files (path) related to this patient case, in json format.
    
<!-- END_39dff5567a0a54c0d2d2d735d9b83847 -->

<!-- START_e0f7f79784fedb525094a32ecff6817c -->
## Delete patient case
Delete patient case by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCase/1"
);


fetch(url, {
    method: "DELETE",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/doctor/patientCase/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the case.

<!-- END_e0f7f79784fedb525094a32ecff6817c -->

<!-- START_bbffe0ca99bebb1c23df51b5e83746bc -->
## Upload case files
Form request for upload a any files relate to a patient case (Such as images)

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/patientCaseFile"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "file": "in"
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
    "message": "上传成功",
    "path": "patientCase\/DRUCjs92FfgYEXY0DFTa5OUSrivUADxqB4sxPopS.jpeg"
}
```

### HTTP Request
`POST api/doctor/patientCaseFile`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `file` | binary |  required  | The file of patient case image.
    
<!-- END_bbffe0ca99bebb1c23df51b5e83746bc -->

<!-- START_ff11b8c6f70c4d81bf372cc58c5ba000 -->
## Get orders
Get all order related to this user

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order"
);

let params = {
    "page": "1",
    "state": "0",
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
            "product_count": 3,
            "total_price": 1000,
            "payment_price": 998,
            "shipping_fee": 14,
            "pay_method": 1,
            "pay_number": "15233958572390",
            "pay_time": "2020-06-19 13:26:43",
            "tracking_number": "SF000002231231",
            "address_id": 1,
            "shipping_time": "2020-06-19 13:26:43",
            "fapiao_id": 1,
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
    `state` |  optional  | The state of order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货) .

<!-- END_ff11b8c6f70c4d81bf372cc58c5ba000 -->

<!-- START_c90b2590e8f65d2cdb6d50d1ea4a1c33 -->
## Get order
Get order by id

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
    "product_count": 3,
    "total_price": 1000,
    "payment_price": 998,
    "shipping_fee": 14,
    "pay_method": 1,
    "pay_number": "15233958572390",
    "pay_time": "2020-06-19 13:26:43",
    "tracking_number": "SF000002231231",
    "address_id": 1,
    "shipping_time": "2020-06-19 13:26:43",
    "fapiao_id": 1,
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

<!-- START_b62b8442e542b07a5b0572b31004646e -->
## Create order
Create a order from patient case. This request only require a case id, other information should fill in with update request.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "patient_case_id": 1
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
    "clinic_id": 1,
    "professor_id": 3,
    "doctor_id": 2,
    "patient_case_id": 1,
    "is_first": false,
    "state": 0,
    "updated_at": "2020-06-20T02:55:40.000000Z",
    "created_at": "2020-06-20T02:55:40.000000Z",
    "id": 2
}
```

### HTTP Request
`POST api/doctor/order`

#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `patient_case_id` | integer |  required  | The patient case id.
    
<!-- END_b62b8442e542b07a5b0572b31004646e -->

<!-- START_5142455a44cce77760a93372b3ce303d -->
## Update order
Update order information

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "state": 1,
    "product_count": 1,
    "total_price": 1,
    "address_id": 1,
    "comments": "1"
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
    "id": 2,
    "created_at": "2020-06-20T08:42:49.000000Z",
    "updated_at": "2020-06-20T08:43:32.000000Z",
    "order_id": 2,
    "product_no": "SFX221",
    "product_name": "Some Product",
    "product_params": "{\"size\": \"100cm\"}",
    "product_count": 3,
    "product_price": 155.2,
    "customer_comments": "Comments content"
}
```

### HTTP Request
`POST api/doctor/order/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `state` | integer |  optional  | The state of the order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货).
        `product_count` | integer |  optional  | The total product count of the order.
        `total_price` | float |  optional  | The total price of the order.
        `address_id` | integer |  optional  | The address id of the order.
        `comments` | string |  optional  | The comments id of the order.
    
<!-- END_5142455a44cce77760a93372b3ce303d -->

<!-- START_308e927be66605a93eaa3ce50573b194 -->
## Create order detail
Create an order detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order/1/detail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_no": "1",
    "product_name": "\"\"",
    "product_params": "{ some: data }",
    "product_count": "15",
    "product_price": "115.5",
    "customer_comments": "\"\""
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
    "order_id": 2,
    "product_no": "SFX220",
    "product_name": "Some Product",
    "product_params": "{\"size\": \"100cm\"}",
    "product_count": 3,
    "product_price": 155.2,
    "customer_comments": "Comments content",
    "updated_at": "2020-06-20T08:42:49.000000Z",
    "created_at": "2020-06-20T08:42:49.000000Z",
    "id": 2
}
```

### HTTP Request
`POST api/doctor/order/{id}/detail`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_no` | required |  optional  | integer The product number of the order detail.
        `product_name` | string |  optional  | The product number of the order detail.
        `product_params` | json_string |  optional  | The product parameters of the order detail.
        `product_count` | required |  optional  | integer The product count of the product.
        `product_price` | required |  optional  | double The product price of the product.
        `customer_comments` | string |  optional  | The comments of the detail.
    
<!-- END_308e927be66605a93eaa3ce50573b194 -->

<!-- START_2eac2bc9fcb58e314b4e0b795facd4d2 -->
## Update order detail
Update order detail by order and order detail id.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order/1/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_no": 1,
    "product_name": "\"\"",
    "product_params": "{ some: data }",
    "product_count": 15,
    "product_price": 115.5,
    "customer_comments": "\"\""
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
    "id": 2,
    "created_at": "2020-06-20T08:42:49.000000Z",
    "updated_at": "2020-06-20T08:43:32.000000Z",
    "order_id": 2,
    "product_no": "SFX221",
    "product_name": "Some Product",
    "product_params": "{\"size\": \"100cm\"}",
    "product_count": 3,
    "product_price": 155.2,
    "customer_comments": "Comments content"
}
```

### HTTP Request
`POST api/doctor/order/{id}/{detailId}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
    `detailId` |  required  | The id of the order detail.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_no` | integer |  optional  | The product number of the order detail.
        `product_name` | string |  optional  | The product number of the order detail.
        `product_params` | json_string |  optional  | The product parameters of the order detail.
        `product_count` | integer |  optional  | The product count of the product.
        `product_price` | float |  optional  | The product price of the product.
        `customer_comments` | string |  optional  | The comments of the detail.
    
<!-- END_2eac2bc9fcb58e314b4e0b795facd4d2 -->

<!-- START_f57b26cdcda986d1b982689130a8dfe9 -->
## Delete order detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/doctor/order/1/1"
);


fetch(url, {
    method: "DELETE",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/doctor/order/{id}/{detailId}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
    `detailId` |  required  | The id of the order detail.

<!-- END_f57b26cdcda986d1b982689130a8dfe9 -->

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
    "http://localhost/api/management/user/aut"
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
    "http://localhost/api/management/clinic/quos"
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
    "http://localhost/api/management/order/fugit"
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

#Professor

APIs for Professor
<!-- START_1fba181e335837dc3bc54f9a6508ad99 -->
## Get patient cases
Get patient case list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/patientCase"
);

let params = {
    "state": "0",
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
            "patient_id": "DLE200617083554",
            "user_id": 2,
            "state": 2,
            "features": "无症状",
            "files": "{}",
            "therapy_program": "无需治疗",
            "patient": {
                "id": "DLE200617083554",
                "created_at": null,
                "updated_at": null,
                "name": "某人",
                "age": 10,
                "sex": 0,
                "comments": "无"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/professor\/patientCase?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/professor\/patientCase?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/professor\/patientCase",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/professor/patientCase`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `state` |  optional  | The state of patient case (-1已取消 0创建 1资料已提交(医生) 2资料需修改 3方案已制定(专家) 4方案待修改 5方案已同意 6已确认 7已下单 8订单已确认 10已存档) .

<!-- END_1fba181e335837dc3bc54f9a6508ad99 -->

<!-- START_40cb20648d9236b56b040e5afa842f40 -->
## Get patient case
Get patient case by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/patientCase/1"
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
            "product_count": 3,
            "total_price": 1000,
            "payment_price": 998,
            "shipping_fee": 14,
            "pay_method": 1,
            "pay_number": "15233958572390",
            "pay_time": "2020-06-19 13:26:43",
            "tracking_number": "SF000002231231",
            "address_id": 1,
            "shipping_time": "2020-06-19 13:26:43",
            "fapiao_id": 1,
            "comments": "无备注"
        },
        {
            "id": 2,
            "created_at": "2020-06-20T02:55:40.000000Z",
            "updated_at": "2020-06-20T02:58:48.000000Z",
            "clinic_id": 1,
            "professor_id": 3,
            "doctor_id": 2,
            "patient_case_id": 1,
            "is_first": 0,
            "state": 0,
            "product_count": null,
            "total_price": 1.2,
            "payment_price": null,
            "shipping_fee": null,
            "pay_method": null,
            "pay_number": null,
            "pay_time": null,
            "tracking_number": null,
            "address_id": null,
            "shipping_time": null,
            "fapiao_id": null,
            "comments": "还行"
        }
    ],
    "patient": {
        "id": "DLE200617083554",
        "created_at": null,
        "updated_at": null,
        "name": "某人",
        "age": 10,
        "sex": 0,
        "comments": "无",
        "doctor": null
    }
}
```

### HTTP Request
`GET api/professor/patientCase/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the patient case.

<!-- END_40cb20648d9236b56b040e5afa842f40 -->

<!-- START_8db6b185b3a837b761ec1a62a74b5117 -->
## Update patient case
Update the patient case detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/patientCase/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "state": 1,
    "therapy_program": "Some detailed information."
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
`POST api/professor/patientCase/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The ID of the case.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `state` | integer |  optional  | The state of this patient case.
        `therapy_program` | string |  optional  | The therapy program for this case.
    
<!-- END_8db6b185b3a837b761ec1a62a74b5117 -->

<!-- START_65a81fc36db06a4b37fd19107fbd7037 -->
## Get orders
Get order list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/order"
);

let params = {
    "state": "0",
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
            "product_count": 3,
            "total_price": 1000,
            "payment_price": 998,
            "shipping_fee": 14,
            "pay_method": 1,
            "pay_number": "15233958572390",
            "pay_time": "2020-06-19 13:26:43",
            "tracking_number": "SF000002231231",
            "address_id": 1,
            "shipping_time": "2020-06-19 13:26:43",
            "fapiao_id": 1,
            "comments": "无备注",
            "doctor": {
                "id": 2,
                "username": "测试医生"
            },
            "clinic": {
                "id": 1,
                "name": "达明口腔门诊部"
            }
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/professor\/order?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/professor\/order?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/professor\/order",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/professor/order`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `state` |  optional  | The state of order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货) .
    `page` |  optional  | The page number to return.

<!-- END_65a81fc36db06a4b37fd19107fbd7037 -->

<!-- START_372616d9caed1549bdfa172f4a86bdd2 -->
## Get order
Get order by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/order/1"
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
    "product_count": 3,
    "total_price": 1000,
    "payment_price": 998,
    "shipping_fee": 14,
    "pay_method": 1,
    "pay_number": "15233958572390",
    "pay_time": "2020-06-19 13:26:43",
    "tracking_number": "SF000002231231",
    "address_id": 1,
    "shipping_time": "2020-06-19 13:26:43",
    "fapiao_id": 1,
    "comments": "无备注",
    "clinic": {
        "id": 1,
        "created_at": null,
        "updated_at": null,
        "name": "达明口腔门诊部",
        "city": "广州",
        "image": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
        "position": "23.544983,113.595114",
        "address": "广州市从化区河东北路5号",
        "intro": "暂无介绍"
    },
    "doctor": {
        "id": 2,
        "created_at": null,
        "updated_at": null,
        "username": "测试医生",
        "email": "me@example.com",
        "type": 0,
        "sex": 0,
        "age": 24,
        "head_portrait": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
        "clinic_id": 1,
        "mobile": "+8613800000000",
        "fix_phone_number": "",
        "certificate": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
        "certificate_checked": 2,
        "wechat": "00000",
        "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
        "school": "没读大学",
        "major": "忽悠专业"
    },
    "fapiao": null,
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
    ],
    "address": {
        "id": 1,
        "created_at": null,
        "updated_at": null,
        "user_id": 2,
        "real_name": "某医生",
        "telephone": "13800000000",
        "country": 86,
        "province": 44,
        "city": 1,
        "area": 84,
        "street": "某街道",
        "zip": 500000,
        "is_default": 1
    }
}
```

### HTTP Request
`GET api/professor/order/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.

<!-- END_372616d9caed1549bdfa172f4a86bdd2 -->

<!-- START_1f68c986366de5895095799e3e54c586 -->
## Update order
Update order information

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/order/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "clinic_id": 1,
    "professor_id": 1,
    "doctor_id": 1,
    "is_first": true,
    "state": 1,
    "product_count": 1,
    "total_price": 1,
    "payment_price": 1,
    "shipping_fee": 1,
    "pay_method": 1,
    "pay_number": "1",
    "pay_time": "1",
    "tracking_number": "1",
    "address_id": 1,
    "shipping_time": "1",
    "fapiao_id": 1,
    "comments": "1"
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
    "id": 2,
    "created_at": "2020-06-20T08:42:49.000000Z",
    "updated_at": "2020-06-20T08:43:32.000000Z",
    "order_id": 2,
    "product_no": "SFX221",
    "product_name": "Some Product",
    "product_params": "{\"size\": \"100cm\"}",
    "product_count": 3,
    "product_price": 155.2,
    "customer_comments": "Comments content"
}
```

### HTTP Request
`POST api/professor/order/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `clinic_id` | integer |  optional  | The clinic id of the order.
        `professor_id` | integer |  optional  | The professor user id of who create this order.
        `doctor_id` | integer |  optional  | The doctor id of the patient case belong to.
        `is_first` | boolean |  optional  | Is this first order for the doctor.
        `state` | integer |  optional  | The state of the order (-1=取消交易,0=未付款,1=已付款,2=已发货,3=已签收,4=退货申请,5=退货中,6=已退货).
        `product_count` | integer |  optional  | The total product count of the order.
        `total_price` | float |  optional  | The total price of the order.
        `payment_price` | float |  optional  | The actual payment amount of the order, usually total price - discount + shipping fee.
        `shipping_fee` | float |  optional  | The shipping fee of the order.
        `pay_method` | integer |  optional  | The pay method of the order (0=cash, 1=Alipay, 2=WechatPay).
        `pay_number` | string |  optional  | The the payment id of the external payment platform, like alipay.
        `pay_time` | datetime |  optional  | The payment time of the order.
        `tracking_number` | string |  optional  | The tracking number of the package.
        `address_id` | integer |  optional  | The address id of the order.
        `shipping_time` | datetime |  optional  | The shipping time of the order.
        `fapiao_id` | integer |  optional  | The fapiao id of the order.
        `comments` | string |  optional  | The comments id of the order.
    
<!-- END_1f68c986366de5895095799e3e54c586 -->

<!-- START_00536e87cd3a573ad443867b8008dcda -->
## Create order detail
Create an order detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/order/1/detail"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_no": "1",
    "product_name": "\"\"",
    "product_params": "{ some: data }",
    "product_count": "15",
    "product_price": "115.5",
    "customer_comments": "\"\""
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
    "order_id": 2,
    "product_no": "SFX220",
    "product_name": "Some Product",
    "product_params": "{\"size\": \"100cm\"}",
    "product_count": 3,
    "product_price": 155.2,
    "customer_comments": "Comments content",
    "updated_at": "2020-06-20T08:42:49.000000Z",
    "created_at": "2020-06-20T08:42:49.000000Z",
    "id": 2
}
```

### HTTP Request
`POST api/professor/order/{id}/detail`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_no` | required |  optional  | integer The product number of the order detail.
        `product_name` | string |  optional  | The product number of the order detail.
        `product_params` | json_string |  optional  | The product parameters of the order detail.
        `product_count` | required |  optional  | integer The product count of the product.
        `product_price` | required |  optional  | double The product price of the product.
        `customer_comments` | string |  optional  | The comments of the detail.
    
<!-- END_00536e87cd3a573ad443867b8008dcda -->

<!-- START_e8f3e4c4f023956b3614a8bc8bdbe0b5 -->
## Update order detail
Update order detail by order and order detail id.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/order/1/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "product_no": 1,
    "product_name": "\"\"",
    "product_params": "{ some: data }",
    "product_count": 15,
    "product_price": 115.5,
    "customer_comments": "\"\""
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
    "id": 2,
    "created_at": "2020-06-20T08:42:49.000000Z",
    "updated_at": "2020-06-20T08:43:32.000000Z",
    "order_id": 2,
    "product_no": "SFX221",
    "product_name": "Some Product",
    "product_params": "{\"size\": \"100cm\"}",
    "product_count": 3,
    "product_price": 155.2,
    "customer_comments": "Comments content"
}
```

### HTTP Request
`POST api/professor/order/{id}/{detailId}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
    `detailId` |  required  | The id of the order detail.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `product_no` | integer |  optional  | The product number of the order detail.
        `product_name` | string |  optional  | The product number of the order detail.
        `product_params` | json_string |  optional  | The product parameters of the order detail.
        `product_count` | integer |  optional  | The product count of the product.
        `product_price` | float |  optional  | The product price of the product.
        `customer_comments` | string |  optional  | The comments of the detail.
    
<!-- END_e8f3e4c4f023956b3614a8bc8bdbe0b5 -->

<!-- START_f621eea0ab6eadab3b118c491611a143 -->
## Delete order detail

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/order/1/1"
);


fetch(url, {
    method: "DELETE",
})
    .then(response => response.json())
    .then(json => console.log(json));
```



### HTTP Request
`DELETE api/professor/order/{id}/{detailId}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the order.
    `detailId` |  required  | The id of the order detail.

<!-- END_f621eea0ab6eadab3b118c491611a143 -->

<!-- START_98ee8a4dfd57993014310b0527480cfc -->
## Get doctors
Get doctor list

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/doctor"
);

let params = {
    "state": "0",
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
            "id": 2,
            "created_at": null,
            "updated_at": null,
            "username": "测试医生",
            "email": "me@example.com",
            "type": 0,
            "sex": 0,
            "age": 24,
            "head_portrait": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
            "clinic_id": 1,
            "mobile": "+8613800000000",
            "fix_phone_number": "",
            "certificate": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
            "certificate_checked": 2,
            "wechat": "00000",
            "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
            "school": "没读大学",
            "major": "忽悠专业"
        }
    ],
    "first_page_url": "http:\/\/localhost:8000\/api\/professor\/doctor?page=1",
    "from": 1,
    "last_page": 1,
    "last_page_url": "http:\/\/localhost:8000\/api\/professor\/doctor?page=1",
    "next_page_url": null,
    "path": "http:\/\/localhost:8000\/api\/professor\/doctor",
    "per_page": 15,
    "prev_page_url": null,
    "to": 1,
    "total": 1
}
```

### HTTP Request
`GET api/professor/doctor`

#### Query Parameters

Parameter | Status | Description
--------- | ------- | ------- | -----------
    `state` |  optional  | The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过) .
    `page` |  optional  | The page number to return.

<!-- END_98ee8a4dfd57993014310b0527480cfc -->

<!-- START_e4606795c4d9f6abaa910fa9a0d719d0 -->
## Get doctor
Get doctor by id

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/doctor/1"
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
    "id": 2,
    "created_at": null,
    "updated_at": null,
    "username": "测试医生",
    "email": "me@example.com",
    "type": 0,
    "sex": 0,
    "age": 24,
    "head_portrait": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
    "clinic_id": 1,
    "mobile": "+8613800000000",
    "fix_phone_number": "",
    "certificate": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
    "certificate_checked": 2,
    "wechat": "00000",
    "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
    "school": "没读大学",
    "major": "忽悠专业",
    "clinic": {
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
}
```

### HTTP Request
`GET api/professor/doctor/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the doctor.

<!-- END_e4606795c4d9f6abaa910fa9a0d719d0 -->

<!-- START_7eec77d560fdd163da4a7642a3e97df4 -->
## Update doctor
Update a doctor info, mainly use to set the certificate status of a doctor.

<br><small style="padding: 1px 9px 2px;font-weight: bold;white-space: nowrap;color: #ffffff;-webkit-border-radius: 9px;-moz-border-radius: 9px;border-radius: 9px;background-color: #3a87ad;">Requires authentication</small>
> Example request:

```javascript
const url = new URL(
    "http://localhost/api/professor/doctor/1"
);

let headers = {
    "Content-Type": "application/json",
    "Accept": "application/json",
};

let body = {
    "certificate_checked": 0,
    "clinic_id": 0
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
    "id": 2,
    "created_at": null,
    "updated_at": null,
    "username": "测试医生",
    "email": "me@example.com",
    "type": 0,
    "sex": 0,
    "age": 24,
    "head_portrait": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
    "clinic_id": 1,
    "mobile": "+8613800000000",
    "fix_phone_number": "",
    "certificate": "http:\/\/pic136.huitu.com\/res\/20200110\/2350458_20200110022605051080_1.jpg",
    "certificate_checked": 2,
    "wechat": "00000",
    "intro": "To specify a list of valid parameters your API route accepts, use the @urlParam, @bodyParam and @queryParam annotations.",
    "school": "没读大学",
    "major": "忽悠专业"
}
```

### HTTP Request
`POST api/professor/doctor/{id}`

#### URL Parameters

Parameter | Status | Description
--------- | ------- | ------- | -------
    `id` |  required  | The id of the doctor.
#### Body Parameters
Parameter | Type | Status | Description
--------- | ------- | ------- | ------- | -----------
    `certificate_checked` | integer |  optional  | The certificate state of the doctor (0未上传，1已上传，2已审核通过，3审核不通过).
        `clinic_id` | integer |  optional  | The clinic id of the doctor.
    
<!-- END_7eec77d560fdd163da4a7642a3e97df4 -->


