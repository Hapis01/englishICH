const puppeteer = require('puppeteer');
(async () => {
    const browser = await puppeteer.launch({ headless: 'new' });
    const page = await browser.newPage();
    page.on('console', msg => console.log('PAGE LOG:', msg.text()));
    page.on('pageerror', error => console.log('PAGE ERROR:', error.message));
    
    // Login first
    await page.goto('http://127.0.0.1:8000/login');
    await page.type('input[name="email"]', 'admin@example.com');
    await page.type('input[name="password"]', 'password');
    await page.click('button[type="submit"]');
    await page.waitForNavigation();
    
    // Go to courses
    await page.goto('http://127.0.0.1:8000/admin/courses');
    
    console.log('Clicking Add Package...');
    await page.evaluate(() => {
        openCourseModal('add');
    });
    
    await browser.close();
})();
