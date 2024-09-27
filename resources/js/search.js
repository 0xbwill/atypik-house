import algoliasearch from 'algoliasearch/lite';
import instantsearch from 'instantsearch.js';
import { searchBox, hits, configure } from 'instantsearch.js/es/widgets';
import { getPropertyByPath } from 'instantsearch.js/es/lib/utils';

const searchClient = algoliasearch('LVDQD3J20N', 'fb5cf0885a11fdb39389fadf414d88f0');

const search = instantsearch({
  indexName: 'logements',
  searchClient,
});

document.addEventListener('livewire:navigated', () => {

  search.addWidgets([
    searchBox({
      container: "#searchbox"
    }),
    configure({
      hitsPerPage: 3,
    }),
    hits({
      container: "#hits",
      templates: {
        item: (hit, { html, components }) => html`
            <a class="hit-title" href="/logement/${hit.slug}" aria-label="logement" wire:navigate>
        <div>
					  ${components.Highlight({ hit, attribute: "title" })}
					<div class="hit-description">
					  ${components.Highlight({ hit, attribute: "description" })}
					</div>
					<div class="hit-capacity">
					  ${components.Highlight({ hit, attribute: "capacity" })}<span> personnes</span>
					</div>
          </div>
          </a>
      `,
      },
    }),
  ])
});


export default search;