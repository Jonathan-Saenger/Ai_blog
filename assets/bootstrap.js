import { startStimulusApp } from '@symfony/stimulus-bundle';

export const app = startStimulusApp(require.context(
    '@symfony/stimulus-bundle/controllers',
    true,
    /\.[jt]sx?$/
));