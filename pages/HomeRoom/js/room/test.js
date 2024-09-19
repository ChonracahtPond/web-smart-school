'use strict';

const webdriver = require('selenium-webdriver');
const seleniumHelpers = require('../../../../../test/webdriver');

let driver;
const path = '/src/content/peerconnection/channel/index.html';
const url = `${process.env.BASEURL ? process.env.BASEURL : ('file://' + process.cwd())}${path}`;

describe('peerconnection and broadcast channels with room key', () => {
  beforeAll(async () => {
    driver = await seleniumHelpers.buildDriver();
  });

  afterAll(() => {
    return driver.quit();
  });

  beforeEach(async () => {
    await driver.get(url);
  });

  it('establishes connections between multiple tabs with room key and verifies video streams', async () => {
    const tabs = [];
    const numTabs = 3; // Number of tabs you want to test with
    const room_key = 'testroom_key'; // The room key to use for the test

    // Open multiple tabs and enter room key
    for (let i = 0; i < numTabs; i++) {
      if (i > 0) {
        await driver.switchTo().newWindow('tab');
      }
      const tabHandle = await driver.getWindowHandle();
      tabs.push(tabHandle);
      await driver.get(url);
      await driver.findElement(webdriver.By.id('room_key')).sendKeys(room_key);
      await driver.findElement(webdriver.By.id('joinButton')).click();
      await driver.wait(() => driver.executeScript(() => {
        return localStream !== null; // eslint-disable-line no-undef
      }));
    }

    // Start the video call in each tab
    for (let i = 0; i < numTabs; i++) {
      await driver.switchTo().window(tabs[i]);
      await driver.findElement(webdriver.By.id('startButton')).click();
      await driver.wait(() => driver.executeScript(() => {
        return Object.keys(peers).length === numTabs - 1; // Ensure connections with other tabs
      }));
    }

    // Verify connections and video streams in each tab
    for (let i = 0; i < numTabs; i++) {
      await driver.switchTo().window(tabs[i]);
      await driver.wait(() => driver.executeScript(() => {
        return Object.keys(peers).length === numTabs - 1; // Ensure connections with other tabs
      }));
      for (let j = 0; j < numTabs; j++) {
        if (i !== j) {
          await driver.wait(() => driver.executeScript(() => {
            return document.getElementById(`remoteVideo-${j}`).readyState === 4; // Verify remote video for each other tab
          }));
        }
      }
    }
  });
});
