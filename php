import requests
import json

SHOPIFY_API_KEY = 'your_api_key'
SHOPIFY_PASSWORD = 'your_api_password'
SHOPIFY_STORE_URL = 'https://yourstore.myshopify.com'

def create_shopify_order(products):
    url = f'{SHOPIFY_STORE_URL}/admin/api/2021-01/orders.json'
    payload = {
        "order": {
            "line_items": []
        }
    }
    for product in products:
        payload['order']['line_items'].append({
            "variant_id": product['variant_id'],
            "quantity": product['quantity']
        })
    headers = {
        'Content-Type': 'application/json',
        'X-Shopify-Access-Token': SHOPIFY_PASSWORD
    }
    response = requests.post(url, headers=headers, data=json.dumps(payload))
    response_json = response.json()
    return response_json['order']

@app.route('/webhook', methods=['POST'])
def webhook():
    payload = request.get_json()
    products = payload['products']
    order = create_shopify_order(products)
    # redirect to Shopify checkout page or do whatever you want with the order
