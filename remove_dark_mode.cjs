const fs = require('fs');
const path = require('path');

function processDir(dir) {
    const files = fs.readdirSync(dir);
    for (const file of files) {
        const fullPath = path.join(dir, file);
        const stat = fs.statSync(fullPath);
        if (stat.isDirectory()) {
            processDir(fullPath);
        } else if (file.endsWith('.blade.php')) {
            let content = fs.readFileSync(fullPath, 'utf8');
            // Remove dark: classes
            content = content.replace(/\bdark:[\w\-\/\[\]#\.]+/g, '');
            // Fix double spaces that might have been created inside class attributes
            content = content.replace(/class=" /g, 'class="');
            
            fs.writeFileSync(fullPath, content);
            console.log(`Cleaned ${fullPath}`);
        }
    }
}

processDir(path.join(__dirname, 'resources/views'));
