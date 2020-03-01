from twilio.rest import Client
def sendSMS(msg):
    account_sid = "YOUR_ID"
    auth_token = "YOUR_TOKEN"
    client = Client(account_sid, auth_token)
    client.api.account.messages.create(to="YOUR_NUM",from_="YOUR_TWILIO_NUM",body=msg)
    print("SMS sent !")

sendSMS("Twilio is slowaf")
