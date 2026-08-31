import re
with open(r'resources/views/dashboard/alerts.blade.php', 'r', encoding='utf-8') as f:
    content = f.read()

pattern = r'<img class="[^"]*" alt="Hazard map" src="https://lh3.googleusercontent.com/[^"]*"/>'
content = re.sub(pattern, '', content)

with open(r'resources/views/dashboard/alerts.blade.php', 'w', encoding='utf-8') as f:
    f.write(content)
print('Removed weird hazard map image')
