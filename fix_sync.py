import re

filepath = r'app/Http/Controllers/Api/SyncController.php'

with open(filepath, 'r', encoding='utf-8') as f:
    content = f.read()

content = content.replace('\\App\\Models\\DemoTelemetri::upsert', '\\App\\Models\\LogTelemetri::upsert')

with open(filepath, 'w', encoding='utf-8') as f:
    f.write(content)
print('Fixed demoSync to use LogTelemetri')
