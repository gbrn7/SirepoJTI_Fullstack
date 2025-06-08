describe('Cek fungsi halaman tugas akhir', () => {
  it('Cek perilaku sistem jika membuka halaman data tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })
  })

  it('Cek perilaku sistem jika menyaring data tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="input-title"]').type('Sistem Informasi-1')
    cy.get('[data-cy="input-username"]').type('bagustejo')
    cy.get('[data-cy="input-student-class-year"]').type('2021')
    cy.get('[data-cy="select-program-study"]').select('3')
    cy.get('[data-cy="select-submission-status"]').select('accepted')
    cy.get('[data-cy="btn-submit"]').click()

    cy.contains('tr', 'Sistem Informasi-1').should('exist');
  })

  it('Cek perilaku sistem jika menambah data tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="btn-link-add-thesis"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management/create')
    })
    cy.get('[data-cy="input-username"]').type('2131762099')
    cy.get('[data-cy="input-title"]').type('test judul')
    cy.get('[data-cy="input-abstract"]').type('test abstract')
    cy.get('[data-cy="input-topic"]').select(1)
    cy.get('[data-cy="input-thesis-type"]').select(1)
    cy.get('[data-cy="input-lecturer"]').select(1)
    cy.get('[data-cy="input-complete-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-abstract-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-list-of-content-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-1-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-2-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-3-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-4-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-5-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-6-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-7-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-bibliography-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-attachment-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.contains('Tugas Akhir Ditambahkan');
  })

  it('Cek perilaku sistem jika menambah data tugas akhir dengan data username yang salah', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="btn-link-add-thesis"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management/create')
    })
    cy.get('[data-cy="input-username"]').type('testdata')
    cy.get('[data-cy="input-title"]').type('test judul')
    cy.get('[data-cy="input-abstract"]').type('test abstract')
    cy.get('[data-cy="input-topic"]').select(1)
    cy.get('[data-cy="input-thesis-type"]').select(1)
    cy.get('[data-cy="input-lecturer"]').select(1)
    cy.get('[data-cy="input-complete-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-abstract-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-list-of-content-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-1-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-2-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-3-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-4-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-5-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-6-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-7-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-bibliography-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-attachment-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management/create')
    })

    cy.contains('Username tidak ditemukan');
  })

  it('Cek perilaku sistem jika edit data tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get(':nth-child(1) > :nth-child(9) > .wrapper > .btn-edit').click();

    cy.get('[data-cy="input-title"]').clear().type('test edit judul')
    cy.get('[data-cy="input-abstract"]').clear().type('test edit abstract')
    cy.get('[data-cy="input-topic"]').select(1)
    cy.get('[data-cy="input-thesis-type"]').select(1)
    cy.get('[data-cy="input-lecturer"]').select(1)
    cy.get('[data-cy="input-complete-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-abstract-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-list-of-content-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-1-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-2-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-3-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-4-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-5-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-6-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-chapter-7-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-bibliography-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="input-attachment-document"]').selectFile("Cypress/document/document_test.pdf", { force: true });
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.contains('Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem jika hapus data tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get(':nth-child(1) > :nth-child(9) > .wrapper > .btn-delete').click();
    cy.get('[data-cy="btn-delete-confirm"]').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.contains('Data Tugas Akhir Dihapus');
  })

  it('Cek perilaku sistem jika melihat detail data tugas akhir', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get(':nth-child(1) > :nth-child(9) > .wrapper > .btn-detail').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document-management')
    })
  })

  it('Cek perilaku sistem jika mengganti status tugas akhir (Accepted)', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get(':nth-child(1) > :nth-child(9) > .wrapper > .btn-detail').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document-management')
    })

    cy.get('[data-cy="btn-thesis-acc"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.contains('Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem jika mengganti status tugas akhir (Declined)', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get(':nth-child(1) > :nth-child(9) > .wrapper > .btn-detail').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/document-management')
    })

    cy.get('[data-cy="btn-thesis-dcd"]').click();
    cy.get('[data-cy="textarea-note"]').type('Note');
    cy.get('[data-cy="btn-thesis-dcd-submit"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.contains('Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem jika mengganti status tugas akhir (Declined) secara massal', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="checkbox-thesis"]').each($el => {
      cy.wrap($el).click();
    });

    cy.get('[data-cy="btn-thesis-dcd"]').click();
    cy.get('[data-cy="textarea-note"]').type('Note');
    cy.get('[data-cy="btn-thesis-dcd-submit"]').click();

    cy.contains('Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem jika mengganti status tugas akhir (Accepted) secara massal', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="checkbox-thesis"]').each($el => {
      cy.wrap($el).click();
    });

    cy.get('[data-cy="btn-thesis-acc"]').click();

    cy.contains('Tugas Akhir Diperbarui');
  })

  it('Cek perilaku sistem saat ekspor data format excel', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="btn-modal-export"]').click();
    cy.get('[data-cy="select-format-export-type"]').select('excel')
    cy.get('[data-cy="btn-export-submit"]').click();
  })

  it('Cek perilaku sistem saat ekspor data format pdf', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-thesis-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/document-management')
    })

    cy.get('[data-cy="btn-modal-export"]').click();
    cy.get('[data-cy="select-format-export-type"]').select('pdf')
    cy.get('[data-cy="btn-export-submit"]').click();
  })
})