import app from 'flarum/admin/app';
import { ConfigureWithOAuthPage } from '@fof-oauth';

app.initializers.add('blt950/oauth-generic', () => {
  app.extensionData.for('blt950-oauth-generic').registerPage(ConfigureWithOAuthPage);
});
