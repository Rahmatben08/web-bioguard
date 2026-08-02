const fs = require('fs');
const text = fs.readFileSync('C:/project pkm/bio_guard_backend/resources/views/dashboard/monitoring.blade.php', 'utf8');

// Find all keys in plannedPaths
const match = text.match(/const plannedPaths = \{/);
if (match) {
    const start = match.index;
    let depth = 0;
    let end = start;
    for (let i = start; i < text.length; i++) {
        if (text[i] === '{') depth++;
        if (text[i] === '}') { depth--; if (depth === 0) { end = i + 1; break; } }
    }
    const block = text.substring(start, end);
    // Extract key names
    const keys = [...block.matchAll(/'([^']+)':/g)].map(m => m[1]);
    console.log('Keys in plannedPaths:');
    keys.forEach(k => {
        // Count coordinates for each key
        const keyStart = block.indexOf("'" + k + "'");
        const arrayStart = block.indexOf('[', keyStart);
        // Find matching ]
        let d = 0;
        let arrayEnd = arrayStart;
        for (let i = arrayStart; i < block.length; i++) {
            if (block[i] === '[') d++;
            if (block[i] === ']') { d--; if (d === 0) { arrayEnd = i; break; } }
        }
        const arrayStr = block.substring(arrayStart, arrayEnd + 1);
        const coordCount = (arrayStr.match(/\[/g) || []).length - 1; // subtract outer bracket
        console.log('  ' + k + ': ' + coordCount + ' coordinates');
    });
} else {
    console.log('plannedPaths NOT FOUND');
}
