const fs = require('fs');

const rsudAlt = fs.readFileSync('alternative_rsud.json', 'utf8');
const rsupAlt = fs.readFileSync('alternative_rsup.json', 'utf8');

const replacementString = `const alternativePaths = {
    'RSUD Palembang BARI': ${rsudAlt},
    'RSUP Dr. Mohammad Hoesin': ${rsupAlt}
};`;

const files = [
    'resources/views/dashboard/fleet.blade.php',
    'resources/views/dashboard/monitoring.blade.php'
];

for (const file of files) {
    let content = fs.readFileSync(file, 'utf8');
    
    // Replace the alternativePaths block. We assume it starts with "const alternativePaths = {"
    // and ends with "};" followed by some blank lines or "const plannedPaths".
    
    const regex = /const alternativePaths = \{[\s\S]*?\};\n/m;
    content = content.replace(regex, replacementString + '\n');
    
    fs.writeFileSync(file, content);
    console.log('Updated ' + file);
}
