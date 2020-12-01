import { ChankyaFrontendPage } from './app.po';

describe('chankya-frontend App', () => {
  let page: ChankyaFrontendPage;

  beforeEach(() => {
    page = new ChankyaFrontendPage();
  });

  it('should display welcome message', () => {
    page.navigateTo();
    expect(page.getParagraphText()).toEqual('Welcome to app!');
  });
});
