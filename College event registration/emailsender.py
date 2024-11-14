import csv
import smtplib
import time
from email.mime.text import MIMEText
from email.mime.multipart import MIMEMultipart

# SMTP server configuration
smtp_server = 'mail.smtp2go.com'
smtp_port = 2525
smtp_username = 'jerry@hxrsh.me'
smtp_password = 'fury@1337'

print(f'Script Started')
# Load registration data from CSV
file_path = 'emails.csv'
def load_data_from_csv(file_path):
    data = []
    with open(file_path, 'r') as csvfile:
        reader = csv.DictReader(csvfile)
        for row in reader:
            data.append(row)
    return data

# Read HTML content from email.html
def read_html_content(filename):
    with open(filename, 'r') as file:
        return file.read()

# Send email with HTML content
def send_registration_email(sender, recipient, uid, name, phone, html_content, reply_to):
    subject = f"Registration for {name} at Parichay"
    body_html = html_content.replace('{uid}', uid).replace('{name}', name).replace('{phone}', phone)

    message = MIMEMultipart()
    message['From'] = sender
    message['To'] = recipient
    message['Subject'] = subject
    message['Reply-To'] = reply_to

    # Attach HTML content
    message.attach(MIMEText(body_html, 'html'))

    with smtplib.SMTP(smtp_server, smtp_port) as server:
        server.starttls()
        server.login(smtp_username, smtp_password)
        server.sendmail(sender, recipient, message.as_string())

# Load registration data from CSV file
registrations_data = load_data_from_csv(file_path)

# Read HTML content from email.html
html_content = read_html_content('email.html')

# Set the number of emails to send per hour
emails_per_hour = 25

# Calculate the time interval in seconds for sending each batch of emails
time_interval = 3600 / emails_per_hour

# Set the sender name and email
sender_name = 'Parichay Registrations'
sender_email = 'registrations@parichay.hxrxh.xyz'
reply_to_address = 'support@parichay.hxrxh.xyz'

# Send emails in batches
for i in range(0, len(registrations_data), emails_per_hour):
    for data in registrations_data[i:i+emails_per_hour]:
        send_registration_email(f'{sender_name} <{sender_email}>', data['EMAIL'], data['UID'], data['NAME'], data['PHONE'], html_content, reply_to_address)
        
        print(f'Sent email to: {data["EMAIL"]}')
        time.sleep(time_interval)

print('All emails sent!')