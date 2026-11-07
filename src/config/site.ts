/**
 * cinevip.com.br — Configuração Geral do Site
 * O Maior Catálogo VIP de Filmes, Séries e TV ao Vivo em 4K
 */

export const SITE_CONFIG = {
  domain: 'cinevip.com.br',
  name: 'Cine VIP',
  tagline: 'O Maior Catálogo VIP de Filmes, Séries e TV ao Vivo em 4K | Teste Grátis 6h',
  description: 'Assista a mais de 120.000 títulos em 4K nativo e canais ao vivo em até 3 telas simultâneas. Filmes, séries, esportes e novelas com liberação imediata via WhatsApp.',
  url: 'https://cinevip.com.br',
  whatsapp: {
    number: '5511972008717',
    formatted: '+55 (11) 97200-8717',
    defaultMessage: 'Olá! Vim pelo Cine VIP (cinevip.com.br) e quero solicitar meu teste grátis de 6 horas!'
  },
  plans: {
    mensal: {
      id: 'mensal',
      name: 'Plano VIP Mensal',
      price: 30,
      period: 'mês',
      screens: '2 Telas Simultâneas',
      popular: false,
      desc: 'Ideal para experimentar o catálogo completo em 2 aparelhos.',
      link: '/ir/plano-mensal/'
    },
    trimestral: {
      id: 'trimestral',
      name: 'Plano VIP Trimestral',
      price: 70,
      period: '3 meses',
      screens: '2 Telas Simultâneas',
      popular: false,
      desc: 'Economize contratando 3 meses para toda a família.',
      link: '/ir/plano-trimestral/'
    },
    semestral: {
      id: 'semestral',
      name: 'Plano VIP Semestral',
      price: 130,
      period: '6 meses',
      screens: '3 Telas Simultâneas',
      popular: true,
      desc: 'O mais escolhido! 3 telas liberadas e máxima economia.',
      link: '/ir/plano-semestral/'
    },
    anual: {
      id: 'anual',
      name: 'Plano VIP Anual',
      price: 240,
      period: '1 ano (R$ 20/mês)',
      screens: '3 Telas Simultâneas',
      popular: false,
      desc: 'Melhor custo-benefício. Apenas R$ 20 por mês para 3 telas.',
      link: '/ir/plano-anual/'
    }
  }
};
