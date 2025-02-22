import { startStimulusApp } from '@symfony/stimulus-bundle';

export const app = startStimulusApp(
    import.meta.glob('/assets/controllers/**/*.{js,jsx,ts,tsx}')
);