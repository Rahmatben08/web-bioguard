const fs = require('fs');
let content = fs.readFileSync('C:/project pkm/bio_guard_backend/resources/views/landing.blade.php', 'utf8');

// 1. Remove global fixed background
content = content.replace(/\{\{-- Full Page Laboratory Background Image --\}\}[\s\S]*?<\/div>\s*<\/div>/, '');

// 2. Change main tag
content = content.replace(/<main class="relative z-10 max-w-7xl mx-auto px-6 pt-32 md:pt-40 pb-20 space-y-32">/, '<main class="relative z-10 w-full flex flex-col pt-24 md:pt-32">');

// 3. Update Hero Section
content = content.replace(/<section id="about" class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center min-h-\[70vh\]">/, 
<section id="about" class="relative w-full py-20 lg:py-32">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_1.png') }}" class="w-full h-full object-cover opacity-20 dark:opacity-[0.15]" alt="Hero Background">
                <div class="absolute inset-0 bg-slate-50/80 dark:bg-slate-950/85 backdrop-blur-[2px]"></div>
                <div class="absolute bottom-0 left-0 w-full h-24 bg-gradient-to-t from-slate-50 dark:from-slate-950 to-transparent"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-8 items-center min-h-[70vh]">);

// 4. Update Logo Meaning Section
content = content.replace(/<section id="logo-meaning" class="space-y-10">/,
<section id="logo-meaning" class="relative w-full py-24 border-t border-slate-200 dark:border-slate-800/50">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_2.png') }}" class="w-full h-full object-cover opacity-15 dark:opacity-10" alt="Section Background">
                <div class="absolute inset-0 bg-white/90 dark:bg-slate-900/90 backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">);

// 5. Update Mascot Section
content = content.replace(/<section id="mascot" class="space-y-10">/,
<section id="mascot" class="relative w-full py-24 border-t border-slate-200 dark:border-slate-800/50">
            <div class="absolute inset-0 z-0">
                <img src="https://images.unsplash.com/photo-1581091226825-a6a2a5aee158?q=80&w=2070&auto=format&fit=crop" class="w-full h-full object-cover opacity-15 dark:opacity-10" alt="Section Background">
                <div class="absolute inset-0 bg-slate-50/90 dark:bg-slate-950/90 backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">);

// 6. Update Vision Mission Section
content = content.replace(/<section id="vision-mission" class="space-y-10">/,
<section id="vision-mission" class="relative w-full py-24 border-t border-slate-200 dark:border-slate-800/50">
            <div class="absolute inset-0 z-0">
                <img src="{{ asset('images/bg_medical_1.png') }}" class="w-full h-full object-cover opacity-15 dark:opacity-10" alt="Section Background">
                <div class="absolute inset-0 bg-white/90 dark:bg-slate-900/90 backdrop-blur-[3px]"></div>
            </div>
            <div class="relative z-10 max-w-7xl mx-auto px-6 space-y-10">);

// Add closing tags for the newly added wrapper divs in each section
// 1. Hero
content = content.replace(/<\/section>\s*\{\{-- Logo Meaning Section --\}\}/, '</div>\n        </section>\n\n        {{-- Logo Meaning Section --}}');
// 2. Logo
content = content.replace(/<\/section>\s*\{\{-- Mascot Section --\}\}/, '</div>\n        </section>\n\n        {{-- Mascot Section --}}');
// 3. Mascot
content = content.replace(/<\/section>\s*\{\{-- Vision Mission Section --\}\}/, '</div>\n        </section>\n\n        {{-- Vision Mission Section --}}');
// 4. Vision Mission
content = content.replace(/<\/section>\s*<\/main>/, '</div>\n        </section>\n\n    </main>');

fs.writeFileSync('C:/project pkm/bio_guard_backend/resources/views/landing.blade.php', content);
console.log('Update complete.');
