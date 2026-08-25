import requests
import re
session = requests.Session()
res1 = session.get('https://bioguard.id/login')
csrf_match = re.search(r'name=\"_token\" value=\"(.*?)\"', res1.text)
if not csrf_match:
    print('Failed to get CSRF token')
    exit(1)
csrf_token = csrf_match.group(1)
print('CSRF token:', csrf_token)

login_data = {
    '_token': csrf_token,
    'email': 'admin@bioguard.id',
    'password': 'password'
}
res2 = session.post('https://bioguard.id/login', data=login_data)
print('Login status:', res2.status_code)

res3 = session.get('https://bioguard.id/dashboard')
print('Dashboard status:', res3.status_code)
if '500 Server Error' in res3.text or 'Server Error' in res3.text or res3.status_code == 500:
    print('Found 500 error in HTML!')
else:
    print('No 500 error found in HTML. Snippet:')
    print(res3.text[0:500])
    
if 'Dasbor Utama' in res3.text:
    print('VERIFIED: Dashboard content successfully rendered')
