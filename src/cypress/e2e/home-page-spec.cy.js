describe('Cek Fungsi Beranda', () => {
  it('Cek Perilaku sistem jika memilih salah satu dokumen', () => {
    cy.visit('/home')

    cy.get(':nth-child(1) > .thesis-title-wrapper > .thesis-title').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document')
    })
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan topik tugas akhir', () => {
    cy.visit('/home')

    cy.get('[data-cy="topic-checkbox-wrapper"] > :nth-child(1) > .checkbox').check();
    cy.get('[data-cy="btn-filter-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
    })

    cy.get('[data-cy="topic-checkbox-wrapper"] > :nth-child(1) > .checkbox').should('be.checked');
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan program studi', () => {
    cy.visit('/home')

    cy.get('[data-cy="prody-checkbox-wrapper"] > :nth-child(1) > .checkbox').check();
    cy.get('[data-cy="btn-filter-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
    })

    cy.get('[data-cy="prody-checkbox-wrapper"] > :nth-child(1) > .checkbox').should('be.checked');
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan jenis tugas akhir', () => {
    cy.visit('/home')

    cy.get('[data-cy="thesis-type-checkbox-wrapper"] > :nth-child(1) > .checkbox').check();
    cy.get('[data-cy="btn-filter-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
    })

    cy.get('[data-cy="thesis-type-checkbox-wrapper"] > :nth-child(1) > .checkbox').should('be.checked');
  })

  it('Cek perilaku sistem jika menyaring data berdasarkan tahun publikasi', () => {
    cy.visit('/home')

    cy.get('[data-cy="input-publication-from"]').type('2025');
    cy.get('[data-cy="input-publication-until"]').type('2025');

    cy.get('[data-cy="btn-filter-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
    })


    cy.get('[data-cy="input-publication-from"]').should('have.value', '2025');
    cy.get('[data-cy="input-publication-until"]').should('have.value', '2025');

  })

  it('Cek perilaku sistem jika menyaring data berdasarkan penulis', () => {
    cy.visit('/home')

    cy.get('[data-cy="input-author"]').type('Asyam');

    cy.get('[data-cy="btn-filter-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.eq('/home')
    })


    cy.get('[data-cy="input-author"]').should('have.value', 'Asyam');
  })
})