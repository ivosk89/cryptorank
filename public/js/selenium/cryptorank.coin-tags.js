let webdriver = require('selenium-webdriver'),
    chrome = require("selenium-webdriver/chrome"),
    By = webdriver.By;

let url = process.argv.slice(2)[0];

(async function() {
    const options = new chrome.Options();
    options.addArguments(
        'headless',
        'disable-gpu',
    );

    let driver = new webdriver.Builder()
        .forBrowser('chrome')
        .setChromeOptions(options)
        .build();

    try {
        driver.get(url);

        let viewAllTags = driver.findElement(By.css("button[class*='view-all-tags-button'"));
        try {
            let viewAllTagsExists = await viewAllTags.getText();
            viewAllTags.click();
            driver.sleep(3000);
        } catch (e) {
          //
        } finally {
            console.log(await driver.getPageSource());
        }
    }
    finally {
        await driver.quit();
    }
})();