WORKFLOW

git clone

composer install

    db_name: prosto
    db_pass: 
    
    authorization token: token-100

1. GET api.your-domain/v1/currency/currencies - list of all currencies in db 

2. GET api.your-domain/v1/currency/view<id> - currency by id

3. php yii currency/update - update db currency from www.cbr.ru

Example:   

Get all currencies
    http://api.prosto.local/v1/currency/currencies/?token=100-token
    
Get currencies with pagination 
    http://api.prosto.local/v1/currency/currencies/?token=100-token&pagination=20

Get currency by id = 1
    http://api.prosto.local/v1/currency/view/?token=100-token&id=1
