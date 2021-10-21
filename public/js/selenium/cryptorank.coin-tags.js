let webdriver = require('selenium-webdriver'),
    chrome = require("selenium-webdriver/chrome"),
    By = webdriver.By;

let url = process.argv.slice(2)[0];

(async function() {
    const options = new chrome.Options();
    options.addArguments('headless');

    let driver = new webdriver.Builder()
        .forBrowser('chrome')
        .setChromeOptions(options)
        .build();

    try {
        driver.get(url);
        let viewAllLink = await driver.findElements(By.css("button[class*='view-all-tags-button__ViewAllTagsButton-sc'"));
        if(viewAllLink.isDisplayed()){
            viewAllLink.click();
        }
    } catch {
    } finally {
        await driver.sleep(3000);
        console.log(await driver.getPageSource());
        await driver.quit();
    }
})();