# dw3nt/fore-up-sdk
PHP SDK for ForeUp's API.
### Examples:
#### Create customer
See `fore-up-php-sdk/src/Objects/Customer.php` for a list of acceptable customer and contact fields.
```
$foreUp = new \Dw3nt\ForeUpSdk\ForeUp([
	"email" => "api_user_email",
	"password" => "api_password"
]);

$courseId = 123;
$customerData = [
		"username" => "username2",
		"company_name" => "MyCompany2",
		"taxable" => true,
		"discount" => 0,
		"opt_out_email" => false,
		"opt_out_text" => false,
		"date_created" => "2017-01-09T06:07:00-0700",
];
$contactData = 	[
		"id" => "2073",
		"first_name" => "FirstName2",
		"last_name" => "LastName2",
		"phone_number" => "801",
		"cell_phone_number" => "123 123 123",
		"email" => "foreup@fake.com",
		"birthday" => "2017-01-09T06:07:00-0700",
		"address_1" => "test 342",
		"address_2" => "test 342",
		"city" => "Lindon",
		"state" => "UT",
		"zip" => "121234",
		"country" => "USA",
		"handicap_account_number" => "123",
		"handicap_score" => "12",
		"comments" => "Best customer ever!!"
];

$response = $foreUp->customers()->create($courseId, $customerData, $contactData);
```