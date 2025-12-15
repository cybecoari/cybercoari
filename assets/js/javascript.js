// src/generators/complete-metadata-generator.js
import { ALL_COUNTRIES } from '../data/all-countries.js';
import fs from 'fs/promises';
import path from 'path';

class CompleteMetadataGenerator {
  constructor() {
    this.countries = ALL_COUNTRIES;
    this.confederations = this.buildConfederations();
  }

  buildConfederations() {
    // Mapeamento de confederações por região
    return {
      // CONMEBOL - América do Sul
      'ar': 'CONMEBOL', 'bo': 'CONMEBOL', 'br': 'CONMEBOL', 'cl': 'CONMEBOL',
      'co': 'CONMEBOL', 'ec': 'CONMEBOL', 'py': 'CONMEBOL', 'pe': 'CONMEBOL',
      'uy': 'CONMEBOL', 've': 'CONMEBOL',
      
      // CONCACAF - América do Norte, Central e Caribe
      'us': 'CONCACAF', 'ca': 'CONCACAF', 'mx': 'CONCACAF', 'bz': 'CONCACAF',
      'cr': 'CONCACAF', 'sv': 'CONCACAF', 'gt': 'CONCACAF', 'hn': 'CONCACAF',
      'ni': 'CONCACAF', 'pa': 'CONCACAF', 'cu': 'CONCACAF', 'do': 'CONCACAF',
      'ht': 'CONCACAF', 'jm': 'CONCACAF', 'bs': 'CONCACAF', 'bb': 'CONCACAF',
      // ... adicione mais países da CONCACAF
      
      // UEFA - Europa
      'al': 'UEFA', 'ad': 'UEFA', 'am': 'UEFA', 'at': 'UEFA', 'az': 'UEFA',
      'by': 'UEFA', 'be': 'UEFA', 'ba': 'UEFA', 'bg': 'UEFA', 'hr': 'UEFA',
      'cy': 'UEFA', 'cz': 'UEFA', 'dk': 'UEFA', 'ee': 'UEFA', 'fi': 'UEFA',
      'fr': 'UEFA', 'ge': 'UEFA', 'de': 'UEFA', 'gr': 'UEFA', 'hu': 'UEFA',
      'is': 'UEFA', 'ie': 'UEFA', 'it': 'UEFA', 'kz': 'UEFA', 'lv': 'UEFA',
      'li': 'UEFA', 'lt': 'UEFA', 'lu': 'UEFA', 'mt': 'UEFA', 'md': 'UEFA',
      'mc': 'UEFA', 'me': 'UEFA', 'nl': 'UEFA', 'mk': 'UEFA', 'no': 'UEFA',
      'pl': 'UEFA', 'pt': 'UEFA', 'ro': 'UEFA', 'ru': 'UEFA', 'sm': 'UEFA',
      'rs': 'UEFA', 'sk': 'UEFA', 'si': 'UEFA', 'es': 'UEFA', 'se': 'UEFA',
      'ch': 'UEFA', 'tr': 'UEFA', 'ua': 'UEFA', 'gb': 'UEFA',
      
      // AFC - Ásia
      'af': 'AFC', 'bh': 'AFC', 'bd': 'AFC', 'bt': 'AFC', 'bn': 'AFC',
      'kh': 'AFC', 'cn': 'AFC', 'tw': 'AFC', 'in': 'AFC', 'id': 'AFC',
      'ir': 'AFC', 'iq': 'AFC', 'jp': 'AFC', 'jo': 'AFC', 'kw': 'AFC',
      'kg': 'AFC', 'la': 'AFC', 'lb': 'AFC', 'my': 'AFC', 'mv': 'AFC',
      'mn': 'AFC', 'mm': 'AFC', 'np': 'AFC', 'kp': 'AFC', 'kr': 'AFC',
      'om': 'AFC', 'pk': 'AFC', 'ph': 'AFC', 'qa': 'AFC', 'sa': 'AFC',
      'sg': 'AFC', 'lk': 'AFC', 'sy': 'AFC', 'tj': 'AFC', 'th': 'AFC',
      'tl': 'AFC', 'ae': 'AFC', 'uz': 'AFC', 'vn': 'AFC', 'ye': 'AFC',
      
      // CAF - África
      'dz': 'CAF', 'ao': 'CAF', 'bj': 'CAF', 'bw': 'CAF', 'bf': 'CAF',
      'bi': 'CAF', 'cv': 'CAF', 'cm': 'CAF', 'cf': 'CAF', 'td': 'CAF',
      'km': 'CAF', 'cg': 'CAF', 'cd': 'CAF', 'ci': 'CAF', 'dj': 'CAF',
      'eg': 'CAF', 'gq': 'CAF', 'er': 'CAF', 'sz': 'CAF', 'et': 'CAF',
      'ga': 'CAF', 'gm': 'CAF', 'gh': 'CAF', 'gn': 'CAF', 'gw': 'CAF',
      'ke': 'CAF', 'ls': 'CAF', 'lr': 'CAF', 'ly': 'CAF', 'mg': 'CAF',
      'mw': 'CAF', 'ml': 'CAF', 'mr': 'CAF', 'mu': 'CAF', 'ma': 'CAF',
      'mz': 'CAF', 'na': 'CAF', 'ne': 'CAF', 'ng': 'CAF', 'rw': 'CAF',
      'st': 'CAF', 'sn': 'CAF', 'sc': 'CAF', 'sl': 'CAF', 'so': 'CAF',
      'za': 'CAF', 'ss': 'CAF', 'sd': 'CAF', 'tz': 'CAF', 'tg': 'CAF',
      'tn': 'CAF', 'ug': 'CAF', 'zm': 'CAF', 'zw': 'CAF',
      
      // OFC - Oceania
      'au': 'OFC', 'fj': 'OFC', 'ki': 'OFC', 'mh': 'OFC', 'fm': 'OFC',
      'nr': 'OFC', 'nz': 'OFC', 'pw': 'OFC', 'pg': 'OFC', 'ws': 'OFC',
      'sb': 'OFC', 'to': 'OFC', 'tv': 'OFC', 'vu': 'OFC'
    };
  }

  getDefaultColors(countryId) {
    // Cores padrão baseadas nas bandeiras (simplificado)
    const colorMap = {
      'br': { primary: '#FFDF00', secondary: '#009C3B', tertiary: '#002776' },
      'ar': { primary: '#74ACDF', secondary: '#FFFFFF', tertiary: '#F6B40E' },
      'us': { primary: '#B22234', secondary: '#3C3B6E', tertiary: '#FFFFFF' },
      'fr': { primary: '#0055A4', secondary: '#FFFFFF', tertiary: '#EF4135' },
      'de': { primary: '#000000', secondary: '#DD0000', tertiary: '#FFCE00' },
      'it': { primary: '#009246', secondary: '#FFFFFF', tertiary: '#CE2B37' },
      'es': { primary: '#AA151B', secondary: '#F1BF00', tertiary: '#FFFFFF' },
      'pt': { primary: '#006600', secondary: '#FF0000', tertiary: '#FFFF00' },
      'gb': { primary: '#012169', secondary: '#C8102E', tertiary: '#FFFFFF' },
      'jp': { primary: '#BC002D', secondary: '#FFFFFF', tertiary: '#000000' }
    };
    
    return colorMap[countryId] || { 
      primary: '#CCCCCC', 
      secondary: '#999999', 
      tertiary: '#666666' 
    };
  }

  async generateAllMetadata() {
    const metadataDir = path.join(process.cwd(), 'assets/metadata');
    await fs.mkdir(metadataDir, { recursive: true });

    console.log(`🏁 Gerando metadados para ${Object.keys(this.countries).length} países...`);

    for (const [countryId, countryName] of Object.entries(this.countries)) {
      await this.generateCountryMetadata(countryId, countryName);
    }

    await this.generateIndexFile();
  }

  async generateCountryMetadata(countryId, countryName) {
    const metadata = {
      id: countryId,
      name: countryName,
      name_pt: countryName, // Em português
      name_en: countryName, // Em inglês (você pode adicionar traduções)
      fifa_code: countryId.toUpperCase(),
      confederation: this.confederations[countryId] || 'UNKNOWN',
      colors: this.getDefaultColors(countryId),
      last_updated: new Date().toISOString().split('T')[0],
      versions: {
        current: '2024',
        available: ['2024']
      },
      urls: {
        svg: `https://cdn.seushield.com/flags/svg/${countryId}.svg`,
        png: {
          small: `https://cdn.seushield.com/flags/png/small/${countryId}.png`,
          normal: `https://cdn.seushield.com/flags/png/normal/${countryId}.png`,
          large: `https://cdn.seushield.com/flags/png/large/${countryId}.png`
        },
        webp: {
          small: `https://cdn.seushield.com/flags/webp/small/${countryId}.webp`,
          normal: `https://cdn.seushield.com/flags/webp/normal/${countryId}.webp`,
          large: `https://cdn.seushield.com/flags/webp/large/${countryId}.webp`
        }
      }
    };

    const filePath = path.join(process.cwd(), `assets/metadata/${countryId}.json`);
    await fs.writeFile(filePath, JSON.stringify(metadata, null, 2));
    console.log(`✅ ${countryId}.json`);
  }

  async generateIndexFile() {
    const indexData = {
      generated_at: new Date().toISOString(),
      total_countries: Object.keys(this.countries).length,
      countries: this.countries
    };

    const filePath = path.join(process.cwd(), 'assets/metadata/index.json');
    await fs.writeFile(filePath, JSON.stringify(indexData, null, 2));
    console.log('📁 index.json gerado!');
  }
}

export default CompleteMetadataGenerator;