describe('Cek fungsi halaman dosen', () => {
  it('Cek perilaku sistem jika membuka halaman data dosen', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })
  })

  it('Cek perilaku sistem jika menyaring data dosen', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();


    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('[data-cy="input-name"]').type('Usman Nurhasan')
    cy.get('[data-cy="btn-submit"]').click()

    cy.contains('tr', 'Usman Nurhasan').should('exist');
  })

  it('Cek perilaku sistem jika menambah data dosen', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('[data-cy="btn-link-add-lecturer"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management/create')
    })
    cy.get('[data-cy="input-username"]').type('testlecturerusername')
    cy.get('[data-cy="input-name"]').type('testlecturer')
    cy.get('[data-cy="select-topic"]').select(1)
    cy.get('[data-cy="input-email"]').type('lecturer@gmail.com')
    cy.get('[data-cy="input-password"]').type('userpass')
    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.contains('Data Dosen Ditambahkan');
  })

  it('Cek perilaku sistem jika menambah data dosen dengan data username yang sudah digunakan', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('[data-cy="btn-link-add-lecturer"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management/create')
    })
    cy.get('[data-cy="input-username"]').type('testlecturerusername')
    cy.get('[data-cy="input-name"]').type('testlecturer')
    cy.get('[data-cy="select-topic"]').select(1)
    cy.get('[data-cy="input-email"]').type('lecturer@gmail.com')
    cy.get('[data-cy="input-password"]').type('11111111')
    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management/create')
    })

    cy.contains('Username Sudah Digunakan, Email Sudah Digunakan');
  })

  it('Cek perilaku sistem jika edit data dosen', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('.table').find('.btn-edit').first().click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/lecturer-management')
    })

    cy.get('[data-cy="input-username"]').clear().type('testusername_edit')
    cy.get('[data-cy="input-name"]').clear().type('firstname_edit')
    cy.get('[data-cy="select-topic"]').select(1)
    cy.get('[data-cy="input-email"]').clear().type('emailtestedit@gmail.com')
    cy.get('[data-cy="input-password"]').clear().type('11111111')
    cy.get('[data-cy="input-profile-picture"]').selectFile("Cypress/images/github.png");
    cy.get('[data-cy="btn-submit"]').click()

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.contains('Data Dosen Diperbarui');
  })

  it('Cek perilaku sistem jika hapus data dosen', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('.table').find('.btn-delete').first().click();

    cy.get('[data-cy="btn-delete-confirm"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.contains('Data Dosen Dihapus');
  })

  it('Cek perilaku sistem jika melihat detail data dosen', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('.table').find('.btn-detail').first().click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.include('/home/lecturer-management')
    })
  })

  it('Cek perilaku sistem jika mengimpor data dosen dari file excel', () => {
    cy.logInAdmin('adminsirepojti', 'adminpass')

    cy.get('[data-cy="btn-navbar-toggler"]').click();
    cy.get('[data-cy="btn-navbar-lecturer-admin"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.get('[data-cy="btn-import-excel"]').click();
    cy.get('[data-cy="btn-download-template"]').click();
    cy.get('[data-cy="select-import-topic"]').select(1);
    cy.get('[data-cy="input-upload-template"]').selectFile("Cypress/document/Template_Dosen.xlsx", { force: true });
    cy.get('[data-cy="btn-submit-template"]').click();

    cy.location().should((loc) => {
      expect(loc.pathname).to.equal('/home/lecturer-management')
    })

    cy.contains('Impor Berhasil');
  })
})
