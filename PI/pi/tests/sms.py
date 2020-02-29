from twilio.rest import Client
def sendSMS(msg):
    account_sid = "AC837856c18f1469554bb919bd638540dc"
    auth_token = "2bb74470d36e9ea1f51047ccbb4ddfeb"
    client = Client(account_sid, auth_token)
    client.api.account.messages.create(to="+917619411837",from_="+12058329946",body=msg)
    print("SMS sent !")

sendSMS("Twilio is slowaf")
